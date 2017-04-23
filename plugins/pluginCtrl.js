'use strict';

app.controller('digitalClockCtrl',function($interval){
  var $temp = this;
  $temp.today = new Date();

  $interval(function(){
    $temp.today = new Date();
  }, 1000);
});

app.controller('todayDateCtrl',function(){

  var $temp = this;

  $temp.now = new Date();


});
