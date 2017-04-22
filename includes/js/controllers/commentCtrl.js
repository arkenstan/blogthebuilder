'use strict';

app.controller('commentCtrl',function(commentFactory,$stateParams,$window){
  var $temp = this;
  $temp.comments = {};
  $temp.reply = {};

  $temp.getComments = function(hash){
    commentFactory.getComments(hash).then(function(msg){
      $temp.comments = msg.data;
    });
  };

  $temp.approveComment = function(hash){
    commentFactory.approve(hash).then(function(msg){
      if(msg.data === '"approved"'){
        $temp.getComments($stateParams.postAccess);
      }
    });
  };

  $temp.makeReply = function(comment_hash){
    $temp.reply.comment_type = 'reply';
    $temp.reply.comment_parent = comment_hash;
    $temp.reply.post_access = $stateParams.postAccess;
    commentFactory.postComment($temp.reply).then(function(msg){
      if(msg.data === '"Successfully replied"'){
        $temp.reply = {};
        $temp.getComments($stateParams.postAccess);
      }
    });
  };


  $temp.getComments($stateParams.postAccess);

});
