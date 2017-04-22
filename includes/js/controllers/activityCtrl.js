'use strict';

app.controller("chartCtrl", function(activityService) {

  var $temp = this;

  $temp.chartSettings = {
    "type":"blogView",
    "scale":"day"
  };

  $temp.getChartData = function(type,scale){
    activityService.getActivityChart(type,scale).then(function(msg){
      console.log(msg.data);
//      $temp.chartData = msg.data;
    });
  };

  $temp.getChartData($temp.chartSettings.type, $temp.chartSettings.scale);

  $temp.chartData = {};

  $temp.chartData.labels = ["January", "February", "March", "April", "May", "June", "Harami"];
  $temp.chartData.series = ['Series A'];
  $temp.chartData.data = [
      [65, 59, 20, 81, 56, 90, 40]
  ];
  $temp.chartData.datasetOverride = [{
      yAxisID: 'y-axis-1'
  }];
  $temp.chartData.options = {
      scales: {
          yAxes: [{
              id: 'y-axis-1',
              type: 'linear',
              display: true,
              position: 'left'
          }]
      }
  };
  $temp.callFunction = function(){
    $temp.chartData.data = [
        [Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1), Math.floor((Math.random()*100)+1)]
    ];
  };
});

app.controller('activityCtrl',function(activityService){

  var $temp = this;

  $temp.initialData = {};

  $temp.initialize = function(){
    activityService.getBootstrapData().then(function(msg){
      console.log(msg.data);
      $temp.initialData = msg.data;
    });
  };

  $temp.initialize();

});
