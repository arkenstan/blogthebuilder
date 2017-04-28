'use strict';

app.factory('postService', function($http,$window){
  return {
    publish:function(post){
      var $promise = $http.post('./includes/functions/posts.php?act=1',post);
      return $promise;
    },
    draft:function(post){
      var $promise = $http.post('./includes/functions/posts.php?act=2',post);
      return $promise;
    },
    draftPost:function(id){
      var fd = new FormData();
      fd.append("post_id",id);
      var $promise = $http.post('./includes/functions/posts.php?act=5',fd,{
        transformRequest:angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    deletethisPost:function(id){
      var fd = new FormData();
      fd.append("post_id",id);
      var $promise = $http.post('./includes/functions/posts.php?act=6',fd,{
        transformRequest:angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    get:function(cate){
      var fd = new FormData();
      fd.append('category',cate);
      var $promise = $http.post('./includes/functions/posts.php?act=3',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
    updatePublish:function(data){
      var $promise = $http.post('./includes/functions/posts.php?act=4',data);
      return $promise;
    },
    updatePost:function(activity,id){
      var $promise;
      var fd = new FormData();
      fd.append('postID',id);
      switch (activity) {
        case 'draft':
          $promise = $http.post('./includes/functions/posts.php?act=2',fd);
          break;
        case 'unpublish':
          $promise = $http.post('./includes/functions/posts.php?act=3',fd);
          break;
        case 'publish':
          $promise = $http.post('./includes/functions/posts.php?act=4',fd);
          break;
        case 'delete':
          $promise = $http.post('./includes/functions/posts.php?act=5',fd);
          break;
        default:
          break;
      }
      return $promise;
    }
  };
});

app.factory('categoryService',function($http){
  return {
    get:function(val){
      var fd = new FormData();
      fd.append('cate',val);
      var $promise = $http.post('./includes/functions/categories.php?act=1',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    }
  };
});
