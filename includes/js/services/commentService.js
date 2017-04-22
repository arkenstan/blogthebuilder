'use strict';

app.factory('commentFactory',function($http){
  return {

    'getComments':function(hash){
      var fd = new FormData();
      fd.append('post_access',hash);
      var $promise = $http.post('./includes/functions/comments.php?action=getComments',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    }

  }
});
