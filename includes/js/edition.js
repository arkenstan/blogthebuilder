(function(){
  var app = angular.module('editUserApp', []);

  /*----------CONTROLLERS----------------*/
  app.controller('',function(){});

  /*----------DIRECTIVES-----------------*/
  app.directive('contentBar', function(){
    return {
      restrict: 'E',
      templateUrl: './includes/packs/edition-side.html'
    };
  });

  app.directive('templateView', function(){
    return {
      restrict: 'E',
      template: '<div class="container col-md-9 right some"><h1>Preview</h1></div>'
    };
  });

})();
