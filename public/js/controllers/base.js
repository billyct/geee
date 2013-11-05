'use strict';

angular.module('geee')
  .controller('BaseCtrl', function ($scope, $cookieStore, $location, tagService) {


  	console.log("have fun");

    $scope.geee = {};
    $scope.geee.code = {};
    $scope.comment = {};
    $scope.comment.code = {};

    $scope.tags = tagService.query();
    $scope.user = $cookieStore.get('user');

    $scope.getAvatarUrl = function(str) {
    	return 'http://www.gravatar.com/avatar/'+md5(str);
    }

    $scope.getImageUrl = function(key) {
    	return 'http://geee.u.qiniudn.com/'+key;
    }
  	
  });
