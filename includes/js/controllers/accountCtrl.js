'use strict';

app.controller('accountSettingsCtrl',function(userService,$window){
  var $temp = this;

  $temp.accountSettings = {};

  userService.getDetails().then(function(response){
    var msg = response.data;
    if(msg == 'E'){
      $window.alert('Unable to connect to database');
    }else{
      $temp.accountSettings = msg;
    }
  });

});
