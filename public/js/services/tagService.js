'use strict';

angular.module('geee')
  .factory('tagService', function ($resource, api_url) {


    return $resource(api_url+'/tags/:id/:action', {action:'@action', id:'@id'}, {
      query: { method:'GET', isArray:true },
      geees: { method:'GET', params:{action:'geees'}, isArray:true }
    });

  });
