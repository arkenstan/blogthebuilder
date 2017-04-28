'use strict';

app.config(function($stateProvider, $urlRouterProvider){
  $urlRouterProvider.otherwise('/home');

  $stateProvider.state('home',{
    url:'/home',
    templateUrl:'./theme/partials/home.tpl.html',
  });

  $stateProvider.state('about',{
    url:'/about',
    templateUrl:'./theme/partials/about.tpl.html',
  });

  $stateProvider.state('contact',{
    url:'/contact',
    templateUrl:'./theme/partials/contact.tpl.html',
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
    templateUrl: './theme/partials/main.tpl.html'
  };
});

app.directive('navbar',function(){
  return {
    return: 'E',
    templateUrl: './theme/partials/navigation.tpl.html'
  };
})

app.directive('home',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/home.tpl.html'
  };
});

app.directive('bannerHome',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/banner-home.tpl.html'
  };
});
app.directive('bannerAbout',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/banner-about.tpl.html'
  };
});
app.directive('bannerContact',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/banner-contact.tpl.html'
  };
});
app.directive('bannerPost',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/banner-post.tpl.html'
  };
});

app.directive('commentForm',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/comment-form.tpl.html'
  };
});

app.directive('comments',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/comments.tpl.html'
  };
});

app.directive('replies',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/replies.tpl.html'
  };
});

app.directive('footer',function(){
  return {
    restrict:'E',
    templateUrl: './theme/partials/footer.tpl.html'
  };
});
