'use strict';

app.config(function($stateProvider, $urlRouterProvider){
  $urlRouterProvider.otherwise('/home');

  $stateProvider.state('home',{
    url:'/home',
    templateUrl:'./theme/partials/main.tpl.html',
  });

  $stateProvider.state('post',{
    url:'/post/:postName',
    templateUrl:'./theme/partials/post.tpl.html',
    controller:'postCtrl as post'
  });

  $stateProvider.state('aboutus',{
    url:'/about',
    templateUrl:'./theme/partials/aboutus.tpl.html',
  });

  $stateProvider.state('contact',{
      url:'/contact',
      templateUrl:'./theme/partials/contact.tpl.html',
    });

    $stateProvider.state('blogPosts',{
      url:'/posts',
      templateUrl:'./theme/partials/blog.tpl.html',
      controller:'postCtrl as post'
    });

});

app.directive('themeGoesHere',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/structure.tpl.html',
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

app.directive('pageFooter',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/footer.tpl.html'
  };
});

app.directive('commentForm',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/commentForm.tpl.html'
  };
});

app.directive('replies',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/reply.tpl.html'
  };
});

app.directive('templatenav',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/nav.tpl.html'
  };
});


app.directive('banner',function(){
  return {
    restrict: 'E',
    templateUrl: './theme/partials/blogBanner.tpl.html'
  };
});
