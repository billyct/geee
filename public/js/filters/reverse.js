/*global define*/
'use strict';


angular.module('geee')
	.filter('reverse', function() {
		return function(items) {
			return items.slice().reverse();
		};
	});