'use strict';

app.controller('pluginCtrl',function(pluginService,$window){

  var $temp = this;

  $temp.pluginList = {};
  $temp.getPluginsList = function(){
    pluginService.getPlugins().then(function(msg){
      $temp.pluginList = msg.data;
    });
  };

  $temp.submitChanges = function(){
    pluginService.updateChanges($temp.pluginList).then(function(msg){
      $window.alert(msg.data);
      $temp.getPluginsList();
    });
  };

  $temp.getPluginsList();

});
