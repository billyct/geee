'use strict';

angular.module('geee')
  .directive('slimscroll', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {
        var e = $(element);
        e.slimScroll({
          height: $(window).height() - 51,
          color: "#fff",
          size: "3px",
          touchScrollStep: 750
        });
        
      }
    };
  });
