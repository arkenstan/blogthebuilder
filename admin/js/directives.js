/*
*
* Creator Workspace Directives will Go here
*
*/
window.onload = function(){
  alert("Loaded 2");
};

(function(){

  var app = angular.module('adminDirectives', []);

  app.directive('navbarDashboard', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/navbar_template_dashboard.html'
    };
  });

})();
