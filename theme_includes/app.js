'use strict';

var app = angular.module('userApplication',['ui.bootstrap','ui.router','ngSanitize']);

app.controller('mainCtrl',function(blogContent,$location){
  var $temp = this;
  $temp.blogData = {};
  $temp.posts = {};
  $temp.getBlogData = function(){
    blogContent.getBlogDataAll().then(function(msg){
      console.log(msg.data);
      $temp.blogData = msg.data;
    });
  };

  $temp.goToPost = function(name){
    $location.path('/post/'+name);
  };

  $temp.getPosts = function(num){
    blogContent.getBlogPosts(num).then(function(msg){
      $temp.posts = msg.data;
    });
  };

  $temp.getPosts(2);


});


app.controller('postCtrl', function(blogContent,$stateParams,$window,$location){
  var $temp = this;
  $temp.post = {};
  $temp.comments = {};
  $temp.comment = {};
  $temp.reply = {};

  $temp.getComments = function(hash){
    blogContent.getCommentsOnPost(hash).then(function(msg){
      $temp.comments = msg.data;
    });
  };

  $temp.makeReply = function(comment_hash){
    $temp.reply.comment_type = 'reply';
    $temp.reply.comment_parent = comment_hash;
    $temp.reply.post_access = $temp.post.accessHash;
    blogContent.postComment($temp.reply).then(function(msg){
      if(msg.data === '"Comment posted successfully"'){
        $temp.reply = {};
        $temp.getComments($temp.post.accessHash);
      }
    });
  };

  $temp.makeComment = function(){
    $temp.comment.comment_type = 'comment';
    $temp.comment.post_access = $temp.post.accessHash;
    $temp.comment.comment_parent = $temp.post.accessHash;
    blogContent.postComment($temp.comment).then(function(msg){
      if(msg.data === '"Comment posted successfully"'){
        $temp.comment = {};
        $temp.getComments($temp.post.accessHash);
      }
    });
  };

  $temp.getPost = function(pName){
    blogContent.getSpecificPost(pName).then(function(msg){
      $temp.post = msg.data;
      $temp.comment.post_access = $temp.post.accessHash;
      $temp.comment.comment_parent = $temp.post.accessHash;
      $temp.getComments($temp.post.accessHash);
    });
  };


  $temp.getPost($stateParams.postName);

});
