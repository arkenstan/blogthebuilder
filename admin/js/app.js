/*
*	Created on: 9/12/2016 17:43:47
*/
(function(){

  var app = angular.module('btbApp',['adminDirectives']);

  app.controller('workspaceCtrl', function(){

    this.tab = 1;

    this.isSet = function(check){
      return this.tab === check;
    };

    this.isSetElab = function(from, to){
      if(this.tab >= from && this.tab <= to)
        return true;
      else {
        return false;
      }
    };

    this.setTab = function(setter){
      this.tab = setter;
    };


  });

  app.controller('postCtrl', function(){});
  app.controller('editorController', function(){});

})();
