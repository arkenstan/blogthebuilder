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



app.controller('publishedPostCtrl',function(postService,categoryService,$window){
  var $temp = this;

  $temp.viewing = 1;

  $temp.editorStat = 0;

  $temp.editing = {};

  $temp.orightml = '';
  $temp.htmlcontent = $temp.orightml;
  $temp.disabled = false;
  $temp.head={selected:null};

  $temp.updatePost = function(val){
    $temp.editing.post_status = ((val == 'publish') ? val:'draft');
    postService.updatePublish($temp.editing).then(function(msg){
      var res = msg.data.split('|');
      if(res[0] == 'S'){
        $temp.editing = {};
        $temp.editorSetStatus(0);
      }
      $window.alert(res[2]);
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

app.controller('draftedPostCtrl',function(postService,categoryService,$window){
  var $temp = this;

  $temp.viewing = 1;

  $temp.editorStat = 0;

  $temp.editing = {};

  $temp.orightml = '';
  $temp.htmlcontent = $temp.orightml;
  $temp.disabled = false;
  $temp.head={selected:null};

  $temp.updatePost = function(val){
    $temp.editing.post_status = ((val == 'publish') ? val:'draft');
    postService.updatePublish($temp.editing).then(function(msg){
      var res = msg.data.split('|');
      if(res[0] == 'S'){
        $temp.editing = {};
        $temp.editorSetStatus(0);
      }
      $window.alert(res[2]);
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
    postService.get('draft').then(function(list){
      $temp.postList = list.data;
    });
  };
  $temp.getPosts();
});
