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
  app.directive('statsToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/workspace_stats_toolbar.html'
    };
  });
  app.directive('customizeToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/workspace_custom_toolbar.html'
    };
  });
  app.directive('postToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/workspace_posts_toolbar.html'
    };
  });

  app.directive('commentToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/workspace_comments_toolbar.html'
    };
  });

  app.directive('settingsToolbar', function(){
    return {
      restrict: 'E',
      templateUrl: './templates/workspace_settings_toolbar.html'
    };
  });



})();
