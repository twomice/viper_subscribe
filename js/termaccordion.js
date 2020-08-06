(function ($, Drupal) {
  Drupal.behaviors.termaccordion = {
    attach: function (context, settings) {
      $('.flag-subscribe-content-type').hide();
      $('.flag-subscribe-node').hide();
      $('.flag-subscribe-user').hide();
      $('.flag-subscribe-term').hide();
          if ($('.flag-accordion').length < 1) {
            $('.flag-subscribe-content-type').add('.flag-subscribe-node').add('.flag-subscribe-term').add('.flag-subscribe-user').wrapAll('<div class="flag-accordion"></div>');
            $('<div id="flag-toggle" style="cursor:pointer"><h3>Click for Subscription Options</h3></div>').insertBefore('.flag-accordion');
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
