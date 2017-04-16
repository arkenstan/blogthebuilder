'use strict';

app.factory('blogContent',function($http){

  return {
    getBlogDataAll:function(){
      var $promise = $http.get('./api/v1/blogDomain.php?pleaseThrow=blogcontentall');
      return $promise;
    },
    getBlogData:function(){
      var $promise = $http.get('./api/v1/blogDomain.php?pleaseThrow=blogcontent');
      return $promise;
    },
    getSpecificPost:function(post_name){
      var $promise = $http.get('./api/v1/blogDomain.php?postView='+post_name);
      return $promise;
    }
  };

});
