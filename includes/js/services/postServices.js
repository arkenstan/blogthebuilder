'use strict';

app.factory('postService', function($http,$window){
  return {
    addPost:function(post){
      var $promise = $http.post('./includes/functions/posts.php?act=1',post);
      return $promise;
    },
    updatePost:function(activity,post){
      var $promise,id;
      switch (activity) {
        case 'draft':
          id = post.post_id;
          $promise = $http.post('./includes/functions/posts.php?act=2',id);
          break;
        case 'unpublish':
          id = post.post_id;
          $promise = $http.post('./includes/functions/posts.php?act=3',id);
          break;
        default:
          $promise = $http.post('./includes/functions/posts.php?act=4',post);
          break;
      }
      return $promise;
    },
    deletePost:function(postID){
      var $promise = $http.post('./includes/functions/posts.php?act=5',postID);
      return $promise;
    },
  };
});
