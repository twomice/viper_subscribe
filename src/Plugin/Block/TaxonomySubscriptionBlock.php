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
 *   id = "taxonomy_subscription_block",
 *   admin_label = @Translation("Taxonomy Subscription Block"),
 *   category = @Translation("Viper Subscribe"),
 * )
 */
class TaxonomySubscriptionBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    //get terms where this user is subscribed
    $uid = \Drupal::currentUser()->id();
    $query = \Drupal::database()
      ->select('flagging', 'f')
      ->fields('f', ['entity_id'])
      ->condition('f.uid', $uid)
      ->condition('f.entity_type', 'term');
    $result = $query->execute()
      ->fetchAll();
    //collect the terms where this user is subbed (these are already displayed)
    $existing = [];
    foreach ($result as $row) {
      $existing[$row->entity_id] = $row->entity_id;
    }
    //specify which vocabs we are including to be subscribable
    $vocabs = ['forums', 'fellows_cohort', 'vocabulary_5', 'vocabulary_3'];
    //go get the vocabs
    $term_data = [];
    foreach ($vocabs as $vid) {
      $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
      foreach ($terms as $term) {
        $taxon = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->load($term->tid);
        //only collect terms that don't already exist as a subscription
        if (!array_key_exists($taxon->id(), $existing)) {
          $field = 'subscribe_taxonomy_' . $taxon->id();
          $build[$field] = [
            '#lazy_builder' => ['flag.link_builder:build',
              [
                $taxon->getEntityTypeId(),
                $taxon->id(),
                'subscribe_term',
              ],
            ],
            '#create_placeholder' => TRUE,
            '#weight' => 10,
          ];
          //add this id to our JS so we can go mangle the link title later this is a hack because tokens aren't working for flag links
          $computed_settings[$taxon->id()] = $taxon->getName();
        }
      }
    }
    //attach js to deal with names because tokens don't work in flag links
    $build['#attached']['library'][] = 'viper_subscribe/taxonomysubscriptionnames';
    $build['#attached']['drupalSettings']['viper_subscribe']['taxonomysubscriptionnames'] = $computed_settings;

    return $build;
  }

}
