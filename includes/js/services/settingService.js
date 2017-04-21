'use strict';

app.service('showEditor',function(){
  this.editorBool = 0;
  this.set = function(val){
    this.editorBool = val;
  };
  this.getBool = function(){
    return this.editorBool === 1;
  };
});

app.service('urlStatus',function($location,$window){
  this.currentUrlStatus = function(val){
    return $location.path() === val;
  };
});

app.factory('blogService',function($http){
  return {
    getData:function(){
      var $promise = $http.get('./includes/functions/blog.php?act=5');
      return $promise;
    },
    saveSettings:function(data){
      var $promise = $http.post('./includes/functions/blog.php?act=6',data);
      return $promise;
    }
  };
});
