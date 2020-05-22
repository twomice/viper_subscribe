(function ($, Drupal) {
  Drupal.behaviors.taxonomysubscriptionnames = {
    attach: function (context, settings) {
        var subterms = drupalSettings.viper_subscribe.taxonomysubscriptionnames;
        $('.view-id-subscribe_taxonomy_term').hide();
        $.each(subterms, function( index, value ) {
          var str = $('.js-flag-subscribe-term-' + index + ' a').text().replace('[viper_subscribe:term_name]', value);
          $('.js-flag-subscribe-term-' + index + ' a').text(str);
        });
      }
  };
})(jQuery, Drupal);
