'use strict';

angular.module('geee')
  .directive('codemirror', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {
        scope.code = "";
      	 var editor = CodeMirror.fromTextArea($(element)[0], {
    	      lineNumbers: true,
    	      matchBrackets: true,
    	      styleActiveLine: true,
    	      theme: 'monokai'
    	    });
      	 editor.on('change', function(codemirror) {
          
      	 	scope.code = codemirror.getValue();
      	 });


         scope.$watch('code', function(value) {
           if (_.isEmpty(value)) {
              editor.setValue('');
            };
         });

        
      }
    };
  });
