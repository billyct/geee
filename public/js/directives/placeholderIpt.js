'use strict';

angular.module('geee')
  .directive('placeholderIpt', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

      	$(element).focus(function() {
          var e = $(this);
          e.val() === e.attr("placeholder") && (e.val(""), e.removeClass("ph"))
        }).blur(function() {
          var e = $(this);
          ("" === e.val() || e.val() === e.attr("placeholder")) && (e.addClass("ph"), e.val(e.attr("placeholder")))
        }).blur().parents("form").submit(function() {
          $(this).find("[placeholder]").each(function() {
            var e = $(this);
            e.val() === e.attr("placeholder") && e.val("")
          })
        })
        
      }
    };
  });
