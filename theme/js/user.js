'use strict';

app.controller('mainCtrl',function(blogService,postService){
  var $temp = this;

  $temp.blogContent = {};
  $temp.blogPosts = {};
  $temp.getData = function(){
    blogService.getBlogData().then(function(msg){
      console.log(msg);
      $temp.blogContent = msg.data;
    });
  };

  $temp.getPosts = function(){
    postService.get('publish').then(function(msg){
      console.log(msg.data);
      $temp.blogPosts = msg.data;
    });
  }
  $temp.getData();
  $temp.getPosts();
});
