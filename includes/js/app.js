'use strict';
var app = angular.module('btbApp', ['ui.router', 'ui.bootstrap', 'ngAnimate', 'ngSanitize', "chart.js", 'textAngular'])
.controller("chartCtrl", function($scope) {

  $scope.labels = ["January", "February", "March", "April", "May", "June", "July"];
  $scope.series = ['Series A', 'Series B'];
  $scope.data = [
      [65, 59, 20, 81, 56, 55, 40],
      [28, 48, 40, 19, 86, 27, 90]
  ];
  $scope.datasetOverride = [{
      yAxisID: 'y-axis-1'
  }, {
      yAxisID: 'y-axis-2'
  }];
  $scope.options = {
      scales: {
          yAxes: [{
              id: 'y-axis-1',
              type: 'linear',
              display: true,
              position: 'left'
          }, {
              id: 'y-axis-2',
              type: 'linear',
              display: true,
              position: 'right'
          }]
      }
  };
  this.callFunction = function(){
    $scope.data = [
        [Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1)],
        [Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1)]
    ];
  };
});

app.config(function($stateProvider, $urlRouterProvider){
  $urlRouterProvider.otherwise('/login');

  $stateProvider.state('workspace.activity', {
    url: '/activity',
    templateUrl:'./includes/partials/workarea/activity.tpl.html'
  });

  $stateProvider.state('workspace.trends', {
    url: '/trends',
    templateUrl:'./includes/partials/workarea/trend.tpl.html'
  });

  $stateProvider.state('workspace.addpost', {
    url: '/newpost',
    templateUrl:'./includes/partials/workarea/addpost.tpl.html'
  });

  $stateProvider.state('workspace.posts', {
    url: '/posts',
    templateUrl:'./includes/partials/workarea/post.tpl.html'
  });

  $stateProvider.state('workspace.appearance', {
    url: '/appearance',
    templateUrl:'./includes/partials/workarea/appearance.tpl.html'
  });

  $stateProvider.state('workspace.plugins', {
    url: '/plugins',
    templateUrl:'./includes/partials/workarea/plugin.tpl.html'
  });

  $stateProvider.state('workspace.widgets', {
    url: '/widgets',
    templateUrl:'./includes/partials/workarea/widget.tpl.html'
  });

  $stateProvider.state('workspace.blog', {
    url: '/blog',
    templateUrl:'./includes/partials/workarea/blog.tpl.html'
  });

  $stateProvider.state('workspace.privacy', {
    url: '/privacy',
    templateUrl:'./includes/partials/workarea/privacy.tpl.html'
  });

  $stateProvider.state('workspace.account', {
    url: '/account',
    templateUrl:'./includes/partials/workarea/account.tpl.html'
  });

  $stateProvider.state('workspace',{
    url:'/workspace',
    templateUrl:'./includes/partials/main.tpl.html'
  });

  $stateProvider.state('login',{
    url:'/login',
    templateUrl:'./includes/partials/login.tpl.html',
    controller:'loginCtrl as loginc'
  });

});

app.run(function($rootScope,$location,loginService,$window){
  var authenticatedRoutes=['/workspace','/workspace/activity','/workspace/account','/workspace/privacy','/workspace/appearance','/workspace/plugins','/workspace/post'];
  var unauthenticatedRoutes=['/login'];
  $rootScope.$on('$stateChangeStart', function(){
    var temp = loginService.isLogged();
    temp.then(function(darth){
      if(darth.data == 'authenticated'){
        if(unauthenticatedRoutes.indexOf($location.path()) != -1){
          $location.path('/workspace/activity');
        }
      }else if(darth.data == 'unauthenticated'){
        if(authenticatedRoutes.indexOf($location.path()) != -1){
          $location.path('/login');
        }
      }
    });
  });
});


app.controller('mainCtrl', function(loginService){

  this.sidebarTogg = false;

  this.toggleSidebar = function(){
    if(this.sidebarTogg === true){
      this.sidebarTogg = false;
    } else {
      this.sidebarTogg = true;
    }
  };

  this.logout = function(){
    loginService.logout();
  };

});

app.controller('sidebarCtrl', function(){
  this.tab = 5;

  this.setTab = function(val){
    this.tab = val;
  };

  this.isSet = function(check){
    return this.tab === check;
  };

});

  app.controller('wysiwygeditor', function($scope){
		$scope.orightml = '<h2>Try me!</h2><p>textAngular is a super cool WYSIWYG Text Editor directive for AngularJS</p><p><b>Features:</b></p><ol><li>Automatic Seamless Two-Way-Binding</li><li>Super Easy <b>Theming</b> Options</li><li style="color: green;">Simple Editor Instance Creation</li><li>Safely Parses Html for Custom Toolbar Icons</li><li class="text-danger">Doesn&apos;t Use an iFrame</li><li>Works with Firefox, Chrome, and IE8+</li></ol><p><b>Code at GitHub:</b> <a href="https://github.com/fraywing/textAngular">Here</a> </p>';
		$scope.htmlcontent = $scope.orightml;
		$scope.disabled = false;

		$scope.head={selected:null};
	});

  app.controller('privacyCtrl', function($scope)
  {
    $scope.notifyVal = false;
    $scope.notifyFunc = function()
    {
      if(document.getElementById("notify").checked === true)
        return $scope.notifyVal === true;
      else
        return $scope.notifyVal === false;
    };
  });
