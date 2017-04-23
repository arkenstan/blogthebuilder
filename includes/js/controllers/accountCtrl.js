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


app.controller('blogSettingsCtrl',function(blogSettingService,$window){
  var $temp = this;
  $temp.default = 'Default';
  $temp.blogSettingsData = {};
  $temp.timezones = {};
  $temp.locales = {};
  $temp.testing = function(){
    $window.alert('Callsed');
  }
  $temp.getBlogSettings = function(){
    blogSettingService.getSettings().then(function(msg){
      $temp.blogSettingsData = msg.data;
    });
  };
  $temp.updateBlogSettings = function(){
    blogSettingService.updateSettings($temp.blogSettingsData).then(function(msg){
      $temp.getBlogSettings();
    });
  };
  $temp.getTimezones = function(){
    blogSettingService.getTimezones().then(function(msg){
      $temp.timezones = msg.data.timezones;
    });
  };
  $temp.getLocales = function(){
    blogSettingService.getLocale().then(function(msg){
      $temp.locales = msg.data.locales;
    });
  };
  $temp.getBlogSettings();
});
