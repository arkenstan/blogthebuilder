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

app.controller('themeCtrl',function(themeData){
  var $temp = this;

  $temp.data = {};

  $temp.setActive = function(themeId){
    themeData.setThemeActive(themeId).then(function(msg){
      console.log(msg);
      $temp.getThemeData();
    });
  };

  $temp.getThemeData = function(){
    themeData.getCatalog().then(function(msg){
      $temp.data = msg.data;
    });
  };

  $temp.getThemeData();

});
