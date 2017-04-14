'use strict';

var app = angular.module('userApplication',['ui.bootstrap','ui.router','ngSanitize']);


app.factory('blogService',function($http){
  return {
    getBlogData:function(){
      var $promise = $http.get('./theme/resource/data/data.json');
      return $promise;
    }
  };

});
