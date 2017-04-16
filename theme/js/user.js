'use strict';


app.controller('mainCtrl',function(blogContent){
  var $temp = this;

  $temp.content = {};

  $temp.getData = function(){
    blogContent.getBlogDataAll().then(function(msg){
      console.log(msg);
      $temp.content = msg.data;
    });
  };

  $temp.getData();
});

app.controller('postCtrl', function(blogContent,$stateParams,$window,$location){
  var $temp = this;
  $temp.post = {};

  $temp.getSpecificPost = function(){
    blogContent.getSpecificPost($stateParams.postName).then(function(msg){
      console.log(msg);
      if(msg.data == 'E'){
        $location.path('/home');
      }else{
        $temp.post = msg.data;
      }
    });
  };

  $temp.getSpecificPost();


});
