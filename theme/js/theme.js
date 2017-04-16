'use strict';

app.config(function($stateProvider, $urlRouterProvider){
  $urlRouterProvider.otherwise('/home');

  $stateProvider.state('home',{
    url:'/home',
    templateUrl:'./theme/partials/main.tpl.html',
    controller: 'mainCtrl as main'
  });

  $stateProvider.state('post',{
    url:'/post/:postName',
    templateUrl:'./theme/partials/post.tpl.html',
    controller:'postCtrl as post'
  });
});

app.directive('themeGoesHere',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/structure.tpl.html',
    controller: 'mainCtrl as main'
  };
});

app.directive('home',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/home.tpl.html'
  };
});

app.directive('aboutus',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/aboutus.tpl.html'
  };
});

app.directive('contact',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/contact.tpl.html'
  };
});

app.directive('blog',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/blog.tpl.html'
  };
});

app.directive('plugins',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/plugins.tpl.html'
  };
});
