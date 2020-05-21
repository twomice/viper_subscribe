(function ($, Drupal) {
  Drupal.behaviors.contentTypesHide = {
    attach: function (context, settings) {
      $('.view-id-subscribe_node').hide();
    }
  };
})(jQuery, Drupal);
