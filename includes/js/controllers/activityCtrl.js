'use strict';

app.controller("chartCtrl", function(activityService) {

  var $temp = this;

  $temp.chartSettings = {
    "type":"blogView",
    "scale":"day"
  };
  $temp.chartData = {};
  $temp.chart2Data = {};

  $temp.getChartData = function(type){
    $temp.chartSettings.type = type;
    activityService.getActivityChart($temp.chartSettings.type,$temp.chartSettings.scale).then(function(msg){
      $temp.chartData = msg.data;
      $temp.chartData.series = ['Activities'];
    });
  };

  $temp.backEndData = function(){
    activityService.allActivity().then(function(msg){
      console.log(msg.data);
      $temp.chart2Data = msg.data;
      $temp.chartData.series = ['Back End Activity'];
    });
  };
  $temp.getChartData($temp.chartSettings.type);
  $temp.backEndData();


});

app.controller('activityCtrl',function(activityService){

  var $temp = this;

  $temp.initialData = {};

  $temp.initialize = function(){
    activityService.getBootstrapData().then(function(msg){
      $temp.initialData = msg.data;
    });
  };

  $temp.initialize();

});

app.controller('trendCtrl',function(trendService){
  var $temp = this;

  $temp.limit = 20;
  $temp.trends = {};

  $temp.getTrends = function(){
    trendService.getTrendsData($temp.limit).then(function(msg){
      $temp.trends = msg.data;
    });
  };
  $temp.getTrends();

  $temp.loadMore = function(){
    $temp.limit += 20;
    $temp.getTrends();
  };

});
