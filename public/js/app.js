'use strict';

angular.module('geee', ['ngCookies', 'ngResource', 'ui.router'])
  .value('api_url', '/api')
  .config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/');


    $stateProvider
      .state('coffee', {
        url: '/',
        templateUrl: 'views/coffee.html',
        controller: 'MainCtrl'
      })
      .state('tag', {
        url: '/tag/:id',
        templateUrl: 'views/tag.html', 
        controller: 'TagCtrl'
      })
      .state('geee', {
        url : '/geee/:id',
        templateUrl : 'views/geee.html',
        controller : 'GeeeSingleCtrl'
      });

    
  });
