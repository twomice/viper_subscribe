(function ($, Drupal) {
  Drupal.behaviors.termaccordion = {
    attach: function (context, settings) {
          if ($('.flag-accordion').length < 1) {
            $('.flag-subscribe-content-type').add('.flag-subscribe-node').add('.flag-subscribe-term').add('.flag-subscribe-user').wrapAll('<div class="flag-accordion"></div>');
            $('<div id="flag-toggle"><h3>Subscription Options</h3></div>').insertBefore('.flag-accordion');
            $('#flag-toggle').click(function() {
            if($('.flag-subscribe-content-type').is(":visible")) {
              $('.flag-subscribe-content-type').hide('slow');
              $('.flag-subscribe-node').hide('slow');
              $('.flag-subscribe-user').hide('slow');
              $('.flag-subscribe-term').hide('slow');
            }
            else {
              $('.flag-subscribe-content-type').show('slow');
              $('.flag-subscribe-node').show('slow');
              $('.flag-subscribe-user').show('slow');
              $('.flag-subscribe-term').show('slow');
            }
          });
        }
      }
    }
  })(jQuery, Drupal);
