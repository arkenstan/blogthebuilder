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
      fd.append('password',passwordData.pass);
      fd.append('newpassword',passwordData.newpass);
      var $promise = $http.post('./includes/functions/user.php?act=3',fd,{
        transformRequest:angular.identity,
        headers:{'Content-type':undefined}
      });
      return $promise;
    }
  };
});
