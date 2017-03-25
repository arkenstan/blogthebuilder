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
  $urlRouterProvider.otherwise('/activity');

  $stateProvider.state('activity', {
    url: '/activity',
    templateUrl:'./includes/partials/workarea/activity.tpl.html',
  });

  $stateProvider.state('trends', {
    url: '/trends',
    templateUrl:'./includes/partials/workarea/trend.tpl.html',
  });

  $stateProvider.state('addpost', {
    url: '/newpost',
    templateUrl:'./includes/partials/workarea/addpost.tpl.html',
  });

  $stateProvider.state('posts', {
    url: '/posts',
    templateUrl:'./includes/partials/workarea/post.tpl.html',
  });

  $stateProvider.state('appearance', {
    url: '/appearance',
    templateUrl:'./includes/partials/workarea/appearance.tpl.html',
  });

  $stateProvider.state('plugins', {
    url: '/plugins',
    templateUrl:'./includes/partials/workarea/plugin.tpl.html',
  });

  $stateProvider.state('widgets', {
    url: '/widgets',
    templateUrl:'./includes/partials/workarea/widget.tpl.html',
  });

  $stateProvider.state('blog', {
    url: '/blog',
    templateUrl:'./includes/partials/workarea/blog.tpl.html',
  });

  $stateProvider.state('privacy', {
    url: '/privacy',
    templateUrl:'./includes/partials/workarea/privacy.tpl.html',
  });

  $stateProvider.state('account', {
    url: '/account',
    templateUrl:'./includes/partials/workarea/account.tpl.html',
  });

});


app.controller('mainCtrl', function(){

  this.sidebarTogg = false;

  this.toggleSidebar = function(){
    if(this.sidebarTogg === true){
      this.sidebarTogg = false;
    } else {
      this.sidebarTogg = true;
    }
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
	$scope.hidePost = function()
	{
		return $scope.showEditor === true;
	};
	$scope.textValue = "Sample Text for binding";

	$scope.orightml = '<h2>Try me!</h2><p>textAngular is a super cool WYSIWYG Text Editor directive for AngularJS</p><p><b>Features:</b></p><ol><li>Automatic Seamless Two-Way-Binding</li><li>Super Easy <b>Theming</b> Options</li><li style="color: green;">Simple Editor Instance Creation</li><li>Safely Parses Html for Custom Toolbar Icons</li><li class="text-danger">Doesn&apos;t Use an iFrame</li><li>Works with Firefox, Chrome, and IE8+</li></ol><p><b>Code at GitHub:</b> <a href="https://github.com/fraywing/textAngular">Here</a> </p>';
	$scope.htmlcontent = $scope.orightml;
	$scope.disabled = false;

	$scope.head={selected:null};
});
