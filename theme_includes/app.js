'use strict';

var app = angular.module('userApplication',['ui.bootstrap','ui.router','ngSanitize']);

app.controller('mainCtrl',function(blogContent){
  var $temp = this;
  $temp.themeData = {};
  $temp.getThemeData = function(){
    blogContent.getTheme().then(function(msg){
      $temp.themeData = msg.data;
    });
  };

});

app.directive('includes',function(){
  return {
    restrict:'E',
    temaplateUrl: './theme/includes.html',
  };
});
