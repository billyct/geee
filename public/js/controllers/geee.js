'use strict';

angular.module('geee')
  .controller('GeeeCtrl', function ($scope, $cookieStore, $rootScope, $location, $stateParams, $cookieStore, geeeService) {

    var user = $scope.user;
  	if (!_.isEmpty(user)) {
  		$scope.geee.idd = user.idd;
	  	$scope.geee.email = user.email;
  	};
  	

  	$scope.publish = function(geee, tag) {

      geee.images = $scope.images;
      $scope.images = new Array;

      geee.code.content = $scope.code;
      $scope.code = null;

  		var self = this;
      geee.tag = {};
  		geee.tag._id = tag._id;
  		geeeService.save(geee, function(resultback) {

  			self.geee.images = new Array;
  			self.geee.title = '';
  			self.geee.content = '';

  			if (resultback.error) {
  				return false;
  			};

        if (!_.isUndefined($scope.geees)) {
          $scope.geees.splice(0, 0, resultback);
        };
  			
        $scope.imagezone = false;
        $scope.codezone = false;
  			tag.count++;
  			$cookieStore.put('user', {idd: resultback.idd, email: resultback.email});
  		});
  	};

    $scope.like = function(geee) {
      geeeService.like({id: geee._id}, function(resultback) {
        if (!resultback.error) {
          if (_.isUndefined(geee.likes)) {
            geee.likes = 0;
          };
          geee.likes++;
        };
      });
    }


    $scope.showComments = function(geee) {
      // if (_.isUndefined(geee.pageComments)) {
      //   geee.pageComments = 1;
      // };
      // geee.pageComments++;
      geee.pageComments = 2;
      geeeService.comments({id: geee._id, page: geee.pageComments, limit: geee.comments.length}, function(resultback) {
        if (!resultback.error) {

          for (var i = 0; i <= resultback.length - 1; i++) {
            geee.comments.push(resultback[i]);
          };

        };
      });
    }


  	

  });