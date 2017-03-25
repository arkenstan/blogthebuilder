'use strict';

app.directive('bigEars', function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/activity/bigNumbers.html'
  };
});

app.directive('graphs', function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/activity/bigGraphs.html'
  };
});

app.directive('backendTasks', function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/activity/bigTasks.html'
  };
});
