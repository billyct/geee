'use strict';

angular.module('geee')
  .directive('totop', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

      	var e = $(element);
        $(window).scroll(function() {
          $(this).scrollTop() > 150 ? e.fadeIn(100) : e.fadeOut(100)
        }), e.click(function() {
          return $("html, body").animate({
            scrollTop: 0
          }, 200), !1
        });
        
      }
    };
  });
