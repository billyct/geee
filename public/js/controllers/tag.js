'use strict';

angular.module('geee')
  .controller('TagCtrl', function ($scope, $cookieStore, $rootScope, $location, $stateParams, $anchorScroll, tagService) {
  	var id = $stateParams.id;

  	$scope.tag = _.find($scope.tags, function(tag) { return tag['_id'] === id});
  	$scope.geees = tagService.geees({id : id});

    $scope.geee.code.type = $scope.tag.name;
    $scope.comment.code.type = $scope.tag.name;


  	$scope.scrollToGeees = function() {
  		var old = $location.hash();
  		$location.hash('geees');
  		$anchorScroll();
  		$location.hash(old);
  	}


    $scope.tag.btnmore = {
      'text' : '加载更多',
      'disabled' : false
    };

    $scope.more = function(tag) {
      if (_.isUndefined(tag.page)) {
        tag.page = 1;
      };
      tag.page++;
      tagService.geees({id: id, page:tag.page}, function(resultback) {
        if (_.isEmpty(resultback)) {
          tag.page--;
          tag.btnmore = {
            'text' : '没有更多了',
            'disabled' : true
          };
          return false;
        };

        for (var i = resultback.length - 1; i >= 0; i--) {
          $scope.geees.push(resultback[i]);
        };
      });
    }

  });