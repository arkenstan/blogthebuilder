(function(){
  var app = angular.module('userApplication', ['ngRoute','theme_struct','userApi']);

  app.config(function($routeProvider){
    $routeProvider.when("/",{
      templateUrl: './theme/templates/home.html',
      data: {
        title: 'Default-e-Home',
        tab: 1
      }
    }).when("/about",{
      templateUrl: './theme/templates/about.html',
      data: {
        title: 'Default-e-About',
        tab: 2
      }
    }).when("/contact",{
      templateUrl: './theme/templates/contact.html',
      data: {
        title: 'Default-e-Contact',
        tab: 3
      }
    }).when("/blog",{
      templateUrl: './theme/templates/blog.html',
      data: {
        title: 'Default-e-Blog',
        tab: 4
      }
    });
  });

  app.run(['$rootScope', '$route', function($rootScope, $route){
    $rootScope.$on('$routeChangeSuccess', function(){
      document.title = $route.current.data.title;
    });
  }]);

  app.controller('themeCtrl', ['$rootScope','$route','jData',function($rootScope, $route, jData){

    var temp = this;
    $rootScope.$on('$routeChangeSuccess', function(){
      temp.tab = $route.current.data.tab;
    });

    temp.isTab = function(check){
      return check === temp.tab;
    };

    jData.pData().success(function(data){
      temp.homeData = data;
    });

  }]);
})();
