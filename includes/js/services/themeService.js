'use strict';

app.factory('themeData',function($http){

  return {
    getCatalog:function(){
      var $promise = $http.post('./includes/functions/theme.php?act=1');
      return $promise;
    },
    setThemeActive:function(id){
      var fd = new FormData();
      fd.append('theme_id',id);
      var $promise = $http.post('./includes/functions/theme.php?act=2',fd,{
        transformRequest: angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    },
  };

});
