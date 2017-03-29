'use strict';

app.controller('loginCtrl', function(loginService){
  var $temp = this;
  $temp.loginUser = function(){
    loginService.login($temp.users);
  };
});
