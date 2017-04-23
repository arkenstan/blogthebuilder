'use strict';

app.controller("chartCtrl", function(activityService) {

  var $temp = this;

  $temp.chartSettings = {
    "type":"blogView",
    "scale":"day"
  };
  $temp.chartData = {};

  $temp.getChartData = function(type){
    $temp.chartSettings.type = type;
    activityService.getActivityChart($temp.chartSettings.type,$temp.chartSettings.scale).then(function(msg){
      $temp.chartData = msg.data;
      $temp.chartData.series = ['Series A'];
    });
  };

  $temp.getChartData($temp.chartSettings.type);


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
