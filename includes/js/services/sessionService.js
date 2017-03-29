'use strict';

app.factory('sessionService', function($http){
  return {
    set:function(key,value){
      return sessionStorage.setItem(key,value);
    },
    destroy:function(key){
      $http.post('./includes/functions/logout.php');
      return sessionStorage.removeItem(key);
    }
  };
});
