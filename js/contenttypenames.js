(function ($, Drupal) {
  Drupal.behaviors.viperSubscribeContentTypeNames = {
    attach: function (context, settings) {
      var contenttypes = drupalSettings.viper_subscribe.contenttypenames;
      $.each(contenttypes, function( index, value ) {
        var str = $('.js-flag-subscribe-content-type-' + index + ' a').text().replace('[viper_subscribe:bundle]', value);
        $('.js-flag-subscribe-content-type-' + index + ' a').text(str);
      });
    }
  };
})(jQuery, Drupal);
