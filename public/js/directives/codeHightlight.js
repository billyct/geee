'use strict';

angular.module('geee')
  .directive('codeHightlight', ['$timeout', '$interpolate', '$compile', function ($timeout, $interpolate, $compile) {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

        var tmp =  $interpolate($(element).text())(scope);
        if (tmp) {
          $timeout(function() {
            $(element).html(hljs.highlightAuto(tmp).value);
          }, 0);

        };
        

        scope.$watch('geeeSingle.code', function(value) {
          if (!_.isEmpty(value)) {
            var tmp =  $interpolate($(element).text())(scope);
            if (tmp) {
              $timeout(function() {
                $(element).html(hljs.highlightAuto(tmp).value);
              }, 0);

            };
          };
        });

        
        
        
        
      }
    };
  }]);
