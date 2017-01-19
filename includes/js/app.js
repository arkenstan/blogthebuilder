(function(){

  var app = angular.module('btbApp', ['structural-directives']);

  app.controller('sidebarCtrl', function(){
    this.tab = 1;

    this.sidebarTogg = 1;

    this.toggleSidebar = function(){
      if(this.sidebarTogg == 1){
        this.sidebarTogg = 0;
      } else {
        this.sidebarTogg = 1;
      }
    };

    this.setTab = function(val){
      this.tab = val;
    };

    this.isSet = function(check){
      return this.tab === check;
    };

  });


})();
