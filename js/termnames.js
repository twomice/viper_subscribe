(function ($, Drupal) {
  Drupal.behaviors.termnames = {
    attach: function (context, settings) {
      var terms = drupalSettings.viper_subscribe.termnames;
      $.each(terms, function( index, value ) {
        var str = $('.js-flag-subscribe-term-' + index + ' a').text().replace('[viper_subscribe:term_name]', value);
        $('.js-flag-subscribe-term-' + index + ' a').text(str);
      });
      //change the content type flag
      var str2 = $('.flag-subscribe-content-type a').text().replace('[viper_subscribe:bundle]', drupalSettings.viper_subscribe.bundle);
      $('.flag-subscribe-content-type a').text(str2);
    }
  };
})(jQuery, Drupal);
