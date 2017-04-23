'use strict';
var app = angular.module('btbApp', ['ui.router', 'ui.bootstrap', 'ngAnimate', 'ngSanitize', "chart.js", 'textAngular','ngMaterial','ngMessages','material.svgAssetsCache']);

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
        templateUrl:'./includes/partials/workarea/activity.tpl.html',
        controller:'activityCtrl as active'
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
        templateUrl:'./includes/partials/workarea/trend.tpl.html',
        controller:'trendCtrl as trends'
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
  $stateProvider.state('workspace.comments',{
    url:'/comments/:postAccess',
    views: {
      nav:
      {
        templateUrl:'./includes/partials/workarea/navbar.tpl.html'
      },
      content:
      {
        templateUrl:'./includes/partials/posts/comment.tpl.html',
        controller:'commentCtrl as comm'
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

  $stateProvider.state('workspace.appearance.edit', {
    url: '/edit',
    templateUrl:'./includes/partials/appearance/edition.tpl.html',
    controller:'editCtrl as edit'
  });
  $stateProvider.state('workspace.appearance.theme', {
    url: '/theme',
    templateUrl:'./includes/partials/appearance/sthemer.tpl.html',
    controller:'themeCtrl as theme'
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
  var authenticatedRoutes=['/workspace','/workspace/activity','/workspace/trends','/workspace/newpost','/workspace/posts','/workspace/appearance/theme','/workspace/appearance/edit','/workspace/plugins','/workspace/blog','/workspace/account'];
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


app.controller('pluginCtrl', function($window){
    var $temp = this;
    $temp.pluginList = [];

    $temp.list = [
      {pluginName: 'Clock'}
    ];

    $temp.addPlugin = function(value) {
      if($temp.selected === true) {
        $temp.pluginList.push({pluginName: value});
      }
      else if ($temp.selected === false){
        $temp.list.push({pluginName: value});
      }
    };

    $temp.removePlugin = function(index){
      if($temp.selected === true) {
        $temp.list.splice(index, 1);

      }
      else if ($temp.selected === false) {
        $temp.pluginList.splice(index, 1);
      }
    };

    $temp.getValue = function(value) {
      $temp.selectedPlug = value;
    };

});
