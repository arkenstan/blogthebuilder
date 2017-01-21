(function(){

  var app = angular.module('btbApp', ['ngRoute', 'structural-directives']);

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
    this.tab = 1;

    this.setTab = function(val){
      this.tab = val;
    };

    this.isSet = function(check){
      return this.tab === check;
    };

  });

  /*app.controller('chartCtrl',function($scope){
    $scope.labels = ["January", "February", "March", "April", "May", "June", "July"];
    $scope.series = ['Series A', 'Series B'];
    $scope.data = [
        [65, 59, 80, 81, 56, 55, 40],
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
  });*/

})();
