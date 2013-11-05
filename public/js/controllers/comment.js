'use strict';

angular.module('geee')
	.controller('CommentCtrl', function($scope, $cookieStore, $rootScope, $location, commentService) {

	    var user = $scope.user;

	  	if (!_.isEmpty(user)) {
	  		$scope.comment.idd = user.idd;
		  	$scope.comment.email = user.email;
	  	};

		$scope.cmt = function(comment, geee) {

			comment.images = $scope.images;
			$scope.images = new Array;

			comment.code.content = $scope.code;
			$scope.code = null;

			var self = this;
			comment.geee = {
				_id : geee._id
			};
			commentService.save(comment, function(resultback) {

				self.comment.images = new Array;
				self.comment.title = '';
				self.comment.content = '';

				if (resultback.error) {
					return false;
				};

				if (_.isUndefined(geee.comments)) {
					geee.comments = new Array;
				};
				geee.comments.splice(0, 0, resultback);
				geee.commentsCount++;
				
				$scope.imagezonec = false;
				$scope.codezonec = false;
				$cookieStore.put('user', {
					idd: resultback.idd,
					email: resultback.email
				});
			});
		}
	});