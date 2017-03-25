'use strict';

app.directive('posttoolbar', function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/posts/navarea.html'
  };
});

app.directive('allPostTable', function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/posts/postsTable.html'
  };
});
