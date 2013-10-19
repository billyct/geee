'use strict';

angular.module('geee')
  .factory('commentService', function ($resource, api_url) {

    return $resource(api_url+'/comments/:id/:action', {action:'@action', id:'@id'}, {
      save: { method:'POST' },
    });

  });