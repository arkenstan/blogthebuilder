'use strict';

app.factory('activityService', function($http){
  return {

    getBootstrapData:function(){
      var $promise = $http.post('./includes/functions/activity.php?action=initialData');
      return $promise;
    },
    getActivityChart:function(activityType, difference){
      var fd = new FormData();
      fd.append("type",activityType);
      fd.append("scale",difference);
      var $promise = $http.post('./includes/functions/activity.php?action=activityChart',fd,{
        transformRequest:angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    }

  };
});
