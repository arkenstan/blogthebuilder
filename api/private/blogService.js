'use strict';

app.factory('blogContent',function($http){

  return {
    getBlogData:function(){
      var fd = new FormData();
      fd.append('privateAccess','private_api_access');
      var $promise = $http.post('./api/private/blogDomain.php?action=getBlogContent',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    getBlogPosts:function(count){
      var fd = new FormData();
      fd.append('postCount',count);
      fd.append('privateAccess','private_api_access');
      var $promise = $http.post('./api/private/blogDomain.php?action=getBlogPosts',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    }
  };

});
