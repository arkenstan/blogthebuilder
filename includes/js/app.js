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
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/activity.tpl.html'
      }
    }
});

  $stateProvider.state('workspace.trends', {
    url: '/trends',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/trend.tpl.html'
      }
    }
  });

  $stateProvider.state('workspace.addpost', {
    url: '/newpost',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/addpost.tpl.html',
        controller:'postAddCtrl as PA'
      }
    }
  });

  $stateProvider.state('workspace.posts', {
    url: '/posts',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/post.tpl.html'
      }
    }
  });

  $stateProvider.state('workspace.appearance', {
    url: '/appearance',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/appearance.tpl.html'
      }
    }
  });

  $stateProvider.state('workspace.plugins', {
    url: '/plugins',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/plugin.tpl.html'
    }
  }
  });

  $stateProvider.state('workspace.widgets', {
    url: '/widgets',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/widget.tpl.html'
      }
    }
  });

  $stateProvider.state('workspace.blog', {
    url: '/blog',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/blog.tpl.html',
        controller:'blogSettingsCtrl as bset'
      }
    }
  });

  $stateProvider.state('workspace.privacy', {
    url: '/privacy',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/privacy.tpl.html'
      }
    }
  });

  $stateProvider.state('workspace.account', {
    url: '/account',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/workarea/account.tpl.html',
        controller:'accountSettingsCtrl as acc'
      }
    }
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


app.controller('mainCtrl', function(loginService,showEditor,urlStatus, $window){

  this.editorSet = function(val){
    showEditor.set(val);
  };
  this.editorStatus = function(){
    return showEditor.getBool();
  };
  this.urlStat = function(val){
    return urlStatus.currentUrlStatus(val);
  };
  this.sidebarTogg = false;

  this.toggleSidebar = function(){
    if(this.sidebarTogg === true){
      this.sidebarTogg = false;
    } else {
      this.sidebarTogg = true;
    }
  };
  this.sidebarStat = function(){
    return this.sidebarTogg;
  };

  this.logout = function(){
    loginService.logout();
  };
/*
  if($state.includes('workspace.addpost'))
  {
    this.showNav = true;
  }
  else
  {
    this.showNav = false;
  }*/
});

app.controller('sideCtrl',function(urlStatus,userService){
  var $temp = this;
  $temp.userDetails = {};
  userService.getDetails().then(function(msg){
    $temp.userDetails = msg.data;
  });
  $temp.urlStat = function(val){
    return urlStatus.currentUrlStatus(val);
  };
});

app.controller('privacyCtrl', function($scope){
  $scope.notifyVal = false;
  $scope.notifyFunc = function(){
    if(document.getElementById("notify").checked === true)
      return $scope.notifyVal === true;
    else
      return $scope.notifyVal === false;
  };
});
