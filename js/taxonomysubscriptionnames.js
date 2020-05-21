(function ($, Drupal) {
  Drupal.behaviors.taxonomySubscriptionNames = {
    attach: function (context, settings) {
      var terms = drupalSettings.viper_subscribe.taxonomysubscriptionnames;
      $.each(terms, function( index, value ) {
        var str = $('.js-flag-subscribe-term-' + index + ' a').text().replace('[viper_subscribe:term_name]', value);
        $('.js-flag-subscribe-term-' + index + ' a').text(str);
      });
    }
  };
})(jQuery, Drupal);
