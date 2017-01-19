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
      templateUrl: './includes/sidebar.html'
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

})();
