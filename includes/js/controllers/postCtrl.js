'use strict';

app.controller('postAddCtrl',function(postService,categoryService,$window){
  var $temp = this;
  $temp.postData = {};

  $temp.publishPost = function(){
    postService.publish($temp.postData).then(function(response){
      $window.alert(response.data);
    });
  };

  $temp.draftPost = function(){};

  $temp.getCategory = function(val){
    return categoryService.get(val).then(function(response){
      var temp = response.data;
      return temp.categories.map(function(pr){
        return pr.category_name;
      });
    });
  };
});
