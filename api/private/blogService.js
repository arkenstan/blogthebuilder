'use strict';

app.factory('blogContent',function($http){

  return {
    getBlogDataAll:function(){
      var fd = new FormData();
      fd.append('privateAccess','private_api_access');
      var $promise = $http.post('./api/private/blogDomain.php?action=blogContent',fd,{
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
      fd.append('privateAccess','private_api_access');
      var $promise = $http.post('./api/private/blogDomain.php?action=postComment',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    getSpecificPost:function(hash){
      var fd = new FormData();
      fd.append('hash',hash);
      fd.append('privateAccess','private_api_access');
      var $promise = $http.post('./api/private/blogDomain.php?action=getSpecificPost',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    getCommentsOnPost:function(hash){
      var fd = new FormData();
      fd.append('hash',hash);
      fd.append('privateAccess','private_api_access');
      var $promise = $http.post('./api/private/blogDomain.php?action=getComments',fd,{
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
