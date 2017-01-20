(function(){

  var app = angular.module('btbApp', ['structural-directives']);

  app.controller('mainCtrl', function(){

    this.sidebarTogg = false;

    this.toggleSidebar = function(){
      if(this.sidebarTogg == true){
        this.sidebarTogg = false;
      } else {
        this.sidebarTogg = true;
      }
    };

  });

  app.controller('sidebarCtrl', function(){
    this.tab = 1;

    this.setTab = function(val){
      this.tab = val;
    };

    this.isSet = function(check){
      return this.tab === check;
    };

  });


})();
