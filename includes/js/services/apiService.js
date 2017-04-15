'use strict';
app.factory('postPromiseApi',function($http){
  return {
    get:function(){
      var fd = new FormData();
      fd.append('category','publish');
      var $promise = $http.post('./api/v1/posts.php?act=1',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    updateCommentsByOne:function(){
      var $promise = $http.post('./api/v1/posts.php?act=2');
      return $promise;
    },
    updateViewsByOne:function(){
      var $promise = $http.post('./api/v1/posts.php?act=3');
      return $promise;
    },
    updateSharesByOne:function(){
      var $promise = $http.post('./api/v1/posts.php?act=4');
      return $promise;
    }
  };
});
