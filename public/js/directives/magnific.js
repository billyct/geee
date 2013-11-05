'use strict';

angular.module('geee')
  .directive('magnific', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

      	var e = $(element);
        e.magnificPopup({
          delegate: "a.gallery-link",
          type: "image",
          gallery: {
            enabled: !0,
            navigateByImgClick: !0,
            arrowMarkup: '<button type="button" class="mfp-arrow mfp-arrow-%dir%" title="%title%"></button>',
            tPrev: "上一张",
            tNext: "下一张",
            tCounter: '<span class="mfp-counter">%curr% / %total%</span>'
          },
          image: {
            titleSrc: "title"
          }
        });
        
      }
    };
  });
