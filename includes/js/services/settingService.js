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
