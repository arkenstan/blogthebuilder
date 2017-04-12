'use strict';

app.controller('postAddCtrl',function(postService,categoryService,$window){
  var $temp = this;
  $temp.postData = {};

  $temp.publishPost = function(){
    postService.publish($temp.postData).then(function(response){
      $window.alert(response.data);
    });
  };

  $temp.draftPost = function(){
    postService.draft($temp.postData).then(function(response){
      $window.alert(response.data);
    });
  };

  $temp.getCategory = function(val){
    return categoryService.get(val).then(function(response){
      var temp = response.data;
      return temp.categories.map(function(pr){
        return pr.category_name;
      });
    });
  };
});



app.controller('publishedPostCtrl',function(postService,$window){
  var $temp = this;

  $temp.editorStat = 0;

  $temp.editing = {};

  $temp.orightml = '';
  $temp.htmlcontent = $temp.orightml;
  $temp.disabled = false;
  $temp.head={selected:null};


  $temp.editorStatus = function(val){
    return $temp.editorStat === val;
  };
  $temp.editorSetStatus = function(val){
    $temp.editorStat = val;
  };

  $temp.editPost = function(post){
    $temp.editorSetStatus(1);
    $temp.editing = post;
    $temp.editing.post_content_original = post.post_content;
  };


  $temp.postList = {};
  $temp.getPosts = function(){
    postService.get('publish').then(function(list){
      $temp.postList = list.data;
    });
  };
  $temp.getPosts();
});
