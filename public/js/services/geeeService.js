'use strict';

angular.module('geee')
  .factory('geeeService', function ($resource, api_url) {

    return $resource(api_url+'/geees/:id/:action', {action:'@action', id:'@id'}, {
      save: { method:'POST' },
      query: { method:'GET', isArray: true },
      like: { method:'PUT', params:{action: 'like'}},
      comments : { method:'GET', params:{action: 'comments'}, isArray: true },
      get: { method:'GET'}
    });

  });
