'use strict';


app.controller('editCtrl',function(blogService,$window){

  var $temp = this;

  $temp.blogData = {};
  $temp.saveBlogSettings = function(){
    blogService.saveSettings($temp.blogData).then(function(msg){
      $window.alert(msg.data);
      $temp.getBlogData();
    });
  };
  $temp.getBlogData = function(){
    blogService.getData().then(function(msg){
      $temp.blogData = msg.data;
    });
  };
  $temp.getBlogData();
});
