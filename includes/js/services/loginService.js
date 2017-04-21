'use strict';

app.factory('loginService', function($http,$location,sessionService,$window){

  return {

    login:function(user){
      var $promise = $http.post('./includes/functions/login_functions.php?act=1',user);
      $promise.then(function(darth){
        var uid = darth.data;
        uid = uid.split("|");
        if(uid[0] == "S"){
          sessionService.set('uid', uid[1]);
          $location.path('/workspace/activity');
        }else{
          $window.alert(uid[0] + uid[1]);
          $location.path('/login');
        }
      });
    },
    isLogged:function(){
      var $checkSession = $http.post('./includes/functions/login_functions.php?act=2');
      return $checkSession;
    },
    logout:function(){
      sessionService.destroy('uid');
      $location.path('/login');
    }

  };

});
