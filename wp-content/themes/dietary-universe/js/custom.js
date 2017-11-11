var path="http://dietary-universe.stagingdevsite.com/dev/wp-content/themes/dietary-universe/"

jQuery('.owl-carousel').owlCarousel({
          loop: true
          , navText: ['<img src="'+path+'"images/left-arrow.png" alt="prev"/> ', '<img src="'+path+'"images/right-arrow.png" alt="next"/>']
          , margin: 10
          , responsiveClass: true
          , responsive: {
              0: {
                  items: 1
                  , nav: true
              }
              , 600: {
                  items: 3
                  , nav: false
              }
              , 1000: {
                  items: 3
                  , nav: true
                  , loop: false
                  , margin: 30
              }
          }
      })
 jQuery(function () {
      jQuery('a[href="#search"]').on("click", function (event) {
	 
          event.preventDefault();
          jQuery("#search").addClass("open");
          jQuery('#search > form > input[type="search"]').focus();
          jQuery("body").addClass("search-open");
      });
    jQuery("#search button.close").on("click", function (event) {
          jQuery("#search").removeClass("open");
          jQuery("body").removeClass("search-open");
      });
      /* jQuery("form").submit(function (event) {
          event.preventDefault();
          return false;
      }); */
  });
  document.documentElement.addEventListener('touchstart', function (event) {
      if (event.touches.length > 1) {
          event.preventDefault();
      }
  }, false);