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

app.directive('addPost',function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/posts/addPost.tpl.html',
  };
});

app.directive('allPublishedPostTable',function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/posts/publishedPost.tpl.html',
    controller: 'publishedPostCtrl as published'
  };
});

app.directive('allDraftPostTable',function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/posts/draftPost.tpl.html',
    controller: 'draftedPostCtrl as drafted'
  };
});

app.directive('allUnpublishedPostTable',function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/posts/unpublishedPost.tpl.html'
  };
});

app.directive('textEditorPublished',function(){
  return {
    restrict: 'E',
    templateUrl:'./includes/partials/posts/texteditorPublish.html'
  };
});

app.directive('textEditorDrafted',function(){
  return {
    restrict: 'E',
    templateUrl: './includes/partials/posts/texteditorDraft.html'
  };
});
