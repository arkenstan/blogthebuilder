'use strict';

app.controller('accountSettingsCtrl',function(userService,$window){
  var $temp = this;

  $temp.accountSettings = {};
  $temp.passwordData = {};

  $temp.getSettings = function(){
    userService.getDetails().then(function(response){
      var msg = response.data;
      if(msg == 'E'){
        $window.alert('Unable to connect to database');
      }else{
        $temp.accountSettings = msg;
      }
    });
  };

  $temp.updateSettings = function(){
    userService.updateDetails($temp.accountSettings).then(function(msg){
      var message = msg.data.split('|');
      if(message[0] == 'E'){
        $window.alert("Unable make changes please check your network");
      }else{
        $window.alert("Account Settings successfully Updated");
        $temp.getSettings();
      }
    });
  };
  $temp.changePassword = function(){
    if($temp.new != $temp.renew){
      $window.alert('Passwords doesn\'t match');
      $temp.passwordData = {};
    }
    userService.changePassword($temp.passwordData).then(function(msg){
      var message = msg.data.split('|');
      if(message[0] == 'E'){
        $window.alert(message[1]);
      }else{
        $window.alert('Password successfully changed');
        $temp.passwordData = {};
        $temp.getSettings();
      }
    });
  };
  $temp.getSettings();

});


app.controller('blogSettingsCtrl',function(blogSettingService){
  var $temp = this;
  $temp.blogSettingsData = {};
  $temp.getBlogSettings = function(){
    blogSettingService.getSettings().then(function(msg){
      console.log(msg.data);
      $temp.blogSettingsData = msg.data;
    });
  };
  $temp.setBlogSettings = function(){};
  $temp.getTimezones = function(){};
  $temp.getLocales = function(){};
  $temp.getBlogSettings();
});
