/*
*
* Creator Workspace Directives will Go here
*
*/
(function(){

  var app = angular.module('adminDirectives', []);

  app.directive('navbarDashboard', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/navbar_template_dashboard.html'
    };
  });

  app.directive('toolbarDashboard', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/toolbar_template_dashboard.html'
    };
  });

})();
