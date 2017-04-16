'use strict';

app.factory('userService',function($http){
  return {
    userData:{},
    getDetails:function(){
      var $promise = $http.post('./includes/functions/user.php?act=1');
      return $promise;
    },
    updateDetails:function(user){
      var $promise = $http.post('./includes/functions/user.php?act=2',user);
      return $promise;
    },
    changePassword:function(passwordData){
      var fd = new FormData();
      fd.append('password',passwordData.current);
      fd.append('newpassword',passwordData.new);
      var $promise = $http.post('./includes/functions/user.php?act=3',fd,{
        transformRequest:angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    }
  };
});


app.factory('blogSettingService',function($http){
  return {
    getSettings:function(){
      var $promise = $http.post('./includes/functions/blog.php?act=1');
      return $promise;
    },
    setSettings:function(data){
      var $promise = $http.post('./includes/functions/blog.php?act=2',data);
      return $promise;
    },
    getTimezones:function(){
      var $promise = $http.get('./includes/functions/blog.php?act=3');
      return $promise;
    },
    getLocale:function(){
      var $promise = $http.get('./includes/functions/blog.php?act=4');
      return $promise;
    }
  };
});
