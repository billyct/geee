'use strict';

angular.module('geee')
  .controller('GeeeSingleCtrl', function ($scope, $cookieStore, $rootScope, $location, $stateParams, $cookieStore, geeeService) {
  	var id = $stateParams.id;
    
    $scope.geeeSingle = geeeService.get({id: id}, function(geee) {
      $scope.geee.code.type = geee.tag.name;
      $scope.comment.code.type = geee.tag.name;
      $scope.comment.geee = geee;
    });

    
  });