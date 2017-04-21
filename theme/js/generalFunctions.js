'use strict';


app.controller('blogCtrl',function(blogContent, $location){
  var $temp = this;

  $temp.content = {};
  $temp.posts = {};

  $temp.getData = function(){
    blogContent.getBlogData().then(function(msg){
      console.log(msg.data);
      $temp.content = msg.data;
    });
  };

  $temp.getPosts = function(num){
    blogContent.getBlogPosts(num).then(function(msg){
      console.log(msg.data);
      $temp.posts = msg.data;
    });
  };

  $temp.goToPost = function(name){
    $location.path('/post/'+name);
  };

  $temp.getData();
  $temp.getPosts(2);
});

app.controller('postCtrl', function(blogContent,$stateParams,$window,$location){
/*  var $temp = this;
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
*/
});
