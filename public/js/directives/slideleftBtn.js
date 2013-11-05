'use strict';

angular.module('geee')
  .directive('slideleftBtn', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

      	var body = $('body'),
            n = $("#sidebar-left-toggle"),
            a = $(element);

        a.click(function() {
          body.removeClass("sidebar-right-open").toggleClass("sidebar-left-open");
          n.parent("li").toggleClass("active");
          a.parent("li").removeClass("active");
        });
        
      }
    };
  });
