(function(){
  var app = angular.module('theme_struct',[]);

/* GENERAL BLOCKS */
  app.directive("scroll", function ($window) {
      return function(scope, element, attrs) {
          angular.element($window).bind("scroll", function() {
               if (this.pageYOffset >= 1) {
                   scope.boolChangeClass = true;
               } else {
                   scope.boolChangeClass = false;
               }
              scope.$apply();
          });
      };
  });
  app.directive('themeGoesHere', function(){
    return {
      restrict: 'E',
      templateUrl: './theme/templates/structure.html'
    };
  });
  app.directive('themeWrapper', function(){
    return {
      restrict: 'E',
      transclude: 'true',
      template: '<div class="theme-wrapper" ng-transclude></div>'
    };
  });

  app.directive('themeNavbar', function(){
    return {
      restrict: 'E',
      templateUrl: './theme/templates/navbar.html'
    };
  });

  app.directive('themeFooter', function(){
    return {
      restrict: 'E',
      templateUrl: './theme/templates/footer.html'
    };
  });

  app.directive('themeBanner', function(){
    return {
      restrict: 'E',
      templateUrl: './theme/templates/banner.html'
    };
  });

  app.directive('themeBody', function(){
    return {
      restrict: 'E',
      transclude: 'true',
      template: '<div class="container" ng-transclude></div>'
    };
  });

  /* END GENERAL BLOCKS */

})();
