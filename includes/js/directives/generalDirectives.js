'use strict';

app.directive('sidebar', function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/sidebar/sidebar.html',
    controller:'sideCtrl as side'
  };
});

app.directive('workarea', function(){
  return {
    restrict: 'E',
    templateUrl:'./includes/partials/workarea/main.tpl.html'
  };
});

app.directive('navbar', function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/workarea/navbar.tpl.html'
  };
});


/* Appearance Directive */
app.directive('invertCard', function(){
  return {
    restrict:'E',
    transclude:true,
    template: "<div class='invertcard' ng-transclude></div>"
  };
});
app.directive('cardbanner', function(){
  return {
    restrict:'E',
    transclude:true,
    template: "<div class='cardbanner' ng-transclude></div>"
  };
});
app.directive('cardtitle', function(){
  return {
    restrict:'E',
    transclude:true,
    template: "<div class='cardtitle' ng-transclude></div>"
  };
});

app.directive('texteditor', function(){
 return {
   restrict: 'E',
   scope:{
     editing:'=',
     postupdate:'&',
     postdraft:'&',
     postunpublish:'&'
   },
   controller:function($scope, $element, $attrs, $location,$window) {
     $window.alert('something');
   },
   controllerAs:'text',
   templateUrl: './includes/partials/posts/texteditor.html'
 };
});
