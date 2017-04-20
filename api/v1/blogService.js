'use strict';

app.factory('blogContent',function($http){

  return {
    getTheme:function(){
      var $promise = $http.get('./api/v1/blogDomain.php?pleaseThrow=theme');
      return $promise;
    },
    getBlogDataAll:function(){
      var $promise = $http.get('./api/v1/blogDomain.php?pleaseThrow=blogcontentall');
      return $promise;
    },
    getBlogData:function(){
      var $promise = $http.get('./api/v1/blogDomain.php?pleaseThrow=blogcontent');
      return $promise;
    },
    getPostData:function(){
      var $promise = $http.get('./api/v1/blogDomain.php?pleaseThrow=postcontent');
      return $promise;
    },
    getSpecificPost:function(post_name){
      var $promise = $http.get('./api/v1/blogDomain.php?postView='+post_name);
      return $promise;
    }
  };

});
