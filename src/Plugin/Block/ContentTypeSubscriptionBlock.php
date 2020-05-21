<?php

namespace Drupal\viper_subscribe\Plugin\Block;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\user\Entity\User;

/**
 * Provides a Block.
 *
 * @Block(
 *   id = "content_type_subscription_block",
 *   admin_label = @Translation("Content Type Subscription Block"),
 *   category = @Translation("Viper Subscribe"),
 * )
 */
class ContentTypeSubscriptionBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    //get all the node types
    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();
    $options = [];
    foreach ($node_types as $node_type) {
      $options[$node_type->id()] = $node_type->label();
    }
    //get the user ID so we can find their flags
    $uid = \Drupal::currentUser()->id();
    //get the users content_type_subscribe flags
    $query = \Drupal::database()
      ->select('flagging', 'f')
      ->fields('f', ['entity_id'])
      ->condition('f.flag_id', 'subscribe_content_type')
      ->condition('f.entity_type', 'node')
      ->condition('f.uid', $uid);
    $result = $query->execute()
      ->fetchAll();
    //create flag links for the subscribed nodes, then add new flag links for any content types left over not in those nodes
    foreach ($result as $row) {
      $node = \Drupal::entityTypeManager()->getStorage('node')->load($row->entity_id);
      $type = $node->bundle();
      //set an ID so we can go modify this later
      $field = 'subscribe_content_type_' . $row->entity_id;
      //we don't need to repeat this link later because we're already subscribed, save for JS later as well
      $computed_settings[$row->entity_id] = $options[$type];
      unset($options[$type]);
      $build[$field] = [
        '#lazy_builder' => ['flag.link_builder:build',
          [
            $node->getEntityTypeId(),
            $node->id(),
            'subscribe_content_type',
          ],
        ],
        '#create_placeholder' => TRUE,
        '#weight' => 10,
      ];
    }
    //for any leftover content types, create a flag link with the first node we can find of that type
    foreach ($options as $id => $label) {
      $nids = \Drupal::entityQuery('node')
        ->condition('type', $id)
        ->range(0, 1)
        ->execute();
      $nodes = \Drupal::entityTypeManager()
        ->getStorage('node')
        ->loadMultiple($nids);
      //this should only be one
      foreach ($nodes as $node) {
        $type = $node->bundle();
        //set an ID so we can go modify this later
        $field = 'subscribe_content_type_' . $node->id();
        //we don't need to repeat this link later because we're already subscribed, save for JS later as well
        $computed_settings[$node->id()] = $label;
        $build[$field] = [
          '#lazy_builder' => ['flag.link_builder:build',
            [
              'node',
              $node->id(),
              'subscribe_content_type',
            ],
          ],
          '#create_placeholder' => TRUE,
          '#weight' => 10,
        ];
      }
    }
    //attach js to deal with names because tokens don't work in flag links
    $build['#attached']['library'][] = 'viper_subscribe/contenttypenames';
    $build['#attached']['drupalSettings']['viper_subscribe']['contenttypenames'] = $computed_settings;

    return $build;
  }

}
