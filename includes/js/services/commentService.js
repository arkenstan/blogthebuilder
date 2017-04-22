'use strict';

app.factory('commentFactory',function($http){
  return {

    getComments:function(hash){
      var fd = new FormData();
      fd.append('post_access',hash);
      var $promise = $http.post('./includes/functions/comments.php?action=getComments',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    postComment:function(values){
      var fd = new FormData();
      angular.forEach(values, function(value,key){
        fd.append(key,value);
      });
      var $promise = $http.post('./includes/functions/comments.php?action=postComment',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    }

  }
});
