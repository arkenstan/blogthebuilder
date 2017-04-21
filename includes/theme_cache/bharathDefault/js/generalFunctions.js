'use strict';


app.controller('mainCtrl',function(blogContent, $location){
  var $temp = this;

  $temp.content = {};

  $temp.getData = function(){
    blogContent.getBlogDataAll().then(function(msg){
      $temp.content = msg.data;
    });
  };

  $temp.goToPost = function(name){
    $location.path('/post/'+name);
  };

  $temp.getData();
});

app.controller('postCtrl', function(blogContent,$stateParams,$window,$location){
  var $temp = this;
  $temp.post = {};

  $temp.getSpecificPost = function(postName){
    blogContent.getSpecificPost(postName).then(function(msg){
      if(msg.data == 'E'){
        $location.path('/home');
      }else{
        $temp.post = msg.data;
      }
    });
  };

  $temp.getSpecificPost($stateParams.postName);


});
