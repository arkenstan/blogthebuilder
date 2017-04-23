'use strict';

app.factory('pluginService',function($http){
  return {
    getPlugins:function(){
      var $promise = $http.post('./includes/functions/plugins.php?action=getPlugins');
      return $promise;
    },
    updateChanges:function(data){
      var $promise = $http.post('./includes/functions/plugins.php?action=updateChanges',data);
      return $promise;
    }
  };
});
