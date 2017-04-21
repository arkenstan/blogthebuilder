'use strict';

var app = angular.module('userApplication',['ui.bootstrap','ui.router','ngSanitize']);

app.controller('mainCtrl',function(blogContent){
  var $temp = this;
  $temp.themeData = {};
/*  $temp.getThemeData = function(){
    blogContent.getTheme().then(function(msg){
      $temp.themeData = msg.data;
    });
  };*/

});
