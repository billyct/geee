/*global define*/
'use strict';


angular.module('geee')
	.filter('fromNowFilter', function () {
	    return function (input) {
	     	return moment.unix(input).fromNow()
	    };
	});
