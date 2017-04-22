'use strict';

app.controller('commentCtrl',function(commentFactory,$stateParams,$window){
  var $temp = this;
  $temp.comments = {};
  $temp.reply = {};

  $temp.getComments = function(hash){
    commentFactory.getComments(hash).then(function(msg){
      console.log(msg.data);
      $temp.comments = msg.data;
    });
  };

  $temp.makeReply = function(comment_hash){
    $temp.reply.comment_type = 'reply';
    $temp.reply.comment_parent = comment_hash;
    $temp.reply.post_access = $temp.post.accessHash;
    commentFactory.postComment($temp.reply).then(function(msg){
      if(msg.data === '"Comment posted successfully"'){
        $temp.reply = {};
        $temp.getComments($temp.post.accessHash);
      }
    });
  };


  $temp.getComments($stateParams.postAccess);

});
