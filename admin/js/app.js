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

    this.setTab = function(setter){
      this.tab = setter;
    };

  });

})();
