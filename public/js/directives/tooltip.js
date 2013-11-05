'use strict';

angular.module('geee')
  .directive('tooltip', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

      	$(element).tooltip({
          container: "body",
          animation: !1
        })
        
      }
    };
  });
