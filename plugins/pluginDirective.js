'use strict';

app.directive('userPlugins',function(){
  return {
    restrict: 'E',
    templateUrl:'./plugins/userPlugins.tpl.html'
  };
});

app.directive('digitalClock',function(){
  return {
    restrict: 'E',
    templateUrl: './plugins/digitalClock/main.tpl.html',
    controller: 'digitalClockCtrl as dcc'
  };
});


app.directive('todayDate',function(){
  return {
    restrict: 'E',
    templateUrl: './plugins/dateToday/main.tpl.html',
    controller: 'todayDateCtrl as tdc'
  };
});
