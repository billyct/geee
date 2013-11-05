'use strict';

angular.module('geee')
  .directive('textareaElastic', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {
      	$(element).elastic();
      }
    };
  });
