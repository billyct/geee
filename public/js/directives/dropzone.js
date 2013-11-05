'use strict';

angular.module('geee')
  .directive('dropzone', function ($http) {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {
        scope.images = new Array;
        $(element).dropzone({
          url : '/api/images',
          method : 'post',
          clickable: true,
          acceptedFiles : 'image/*',
          addRemoveLinks : true,
          dictCancelUpload : '取消',
          dictCancelUploadConfirmation : '取消上传？',
          dictDefaultMessage : '点击或者拖拽图片上传',
          dictFallbackMessage : '你的浏览器太老了,请更新你的浏览器',
          dictFallbackText : '你只能用下面的表单上传图片了',
          dictInvalidFileType : '图片类型不支持上传',
          dictFileTooBig : '图片太大',
          dictMaxFilesExceeded : '只能上传10张图片',
          dictRemoveFile : '删除',
          maxFilesize : 10,
          init : function() {
            this.on('success', function(file, response) {
              response = $.parseJSON(response);
              $('#publish').attr('disabled', false);
              if (!response.error) {
                $(file.previewElement).attr('key', response.key);
                scope.images.push(response.key);
              };

            });

            this.on("removedfile", function(file) {
              var key = $(file.previewElement).attr('key');
              /** 删除服务端的图片*/
              $http.delete('/api/images/'+key).success(function(response) {
                if (response.error) {
                  return false;
                };
                scope.images = _.without(scope.images, key);
              }).error(function() {
                return false;
              });
            });

            this.on("error", function() {
              alert('有错误');
            });

            this.on("sending", function() {
              $('#publish').attr('disabled', true);
            });
          }
        });
        
        scope.$watch('images', function(value) {
          if (_.isEmpty(value)) {
            $(element).find('.dz-preview.dz-processing.dz-image-preview.dz-success').remove();
            $(element).removeClass('dz-started');
          };
          
        });
        
        

      }
    };
  });
