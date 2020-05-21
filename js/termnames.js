(function ($, Drupal) {
  Drupal.behaviors.myModuleBehavior = {
    attach: function (context, settings) {
      var terms = drupalSettings.viper_subscribe.termnames;
      $.each(terms, function( index, value ) {
        var str = $('.js-flag-subscribe-term-' + index + ' a').text().replace('[viper_subscribe:term_name]', value);
        $('.js-flag-subscribe-term-' + index + ' a').text(str);
      });
    }
  };
})(jQuery, Drupal);
