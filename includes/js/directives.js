(function(){

  var app = angular.module('structural-directives', []);

  app.directive('navbar', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/navbar.html'
    };
  });

  app.directive('workarea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea.html'
    };
  });


  /* Sidebar directives */

  app.directive('sidebar', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/sidebar.html',
      controller: 'sidebarCtrl',
      controllerAs: 'sidebar'
    };
  });

  app.directive('userPortrait',function(){
    return {
      restrict: 'E',
      templateUrl: './includes/sidebar/userPortrait.html'
    };
  });

  app.directive('statFunctions', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/sidebar/stat_functions.html'
    };
  });

  app.directive('postFunctions', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/sidebar/post_functions.html'
    };
  });

  app.directive('customizationFunctions', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/sidebar/customization_functions.html'
    };
  });

  app.directive('settingFunctions', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/sidebar/setting_functions.html'
    };
  });

  /* END SIDEBAR DIRECTIVES */

  /* workarea directives */

  app.directive('activityArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/activity.html'
    };
  });

  app.directive('trendArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/trend.html'
    };
  });

  app.directive('postArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/post.html'
    };
  });

  app.directive('tagArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/tag.html'
    };
  });

  app.directive('appearanceArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/appearance.html'
    };
  });

  app.directive('pluginArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/plugin.html'
    };
  });

  app.directive('widgetArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/widget.html'
    };
  });

  app.directive('blogArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/blog.html'
    };
  });

  app.directive('accountArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/account.html'
    };
  });

  app.directive('privacyArea', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/workarea/privacy.html'
    };
  });

  app.directive('allPostTable', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/packs/postsTable.html'
    };
  });

  app.directive('bigEars', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/packs/bigNumbers.html'
    };
  });

  app.directive('dataGraphs', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/packs/bigGraphs.html'
    };
  });

  app.directive('backendTasks', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/packs/bigTasks.html'
    };
  });

  /* END WORKAREA DIRECTIVES */

})();
