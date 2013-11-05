'use strict';

angular.module('geee')
  .directive('slideleft', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

      	var e = $(element),
            body = $('body'),
            n = $("#sidebar-left-toggle"),
            a = $("#sidebar-right-toggle");
        e.mouseenter(function() {
          body.removeClass("sidebar-right-open").addClass("sidebar-left-open");
          n.parent("li").addClass("active");
          a.parent("li").removeClass("active");
        }).mouseleave(function() {
          body.removeClass("sidebar-left-open");
          n.parent("li").removeClass("active");
        });
        
      }
    };
  });
