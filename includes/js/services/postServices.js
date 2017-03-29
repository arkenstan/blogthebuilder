'use strict';

app.service('postService', ['$http',function($http){
  this.get = function(){};
  this.post = function(postDetails){
    var $promise = $http.post('./includes/functions/posts.php?act=1', postDetails);
  };
  this.delete = function(){};
  this.update = function(){};
}]);
