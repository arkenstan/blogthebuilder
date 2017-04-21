<?php

include 'init.php';

function make_it_count($link,$type,$to,$from){
  $userIP = getUserIP();
  $from = $from == '0' ? '0':$from;
  date_default_timezone_set('UTC');
  $crTime = date('Y-m-d H:i:s');
  if($type == 'postView'){
    mysqli_query($link, "UPDATE posts SET post_view_count = post_view_count+1 WHERE post_name='$to'") or die(mysqli_error($link));
  }else if($type == 'comment'){
    mysqli_query($link, "UPDATE posts SET post_comment_count = post_comment_count+1 WHERE accessHash='$to'") or die(mysqli_error($link));
  }
  $to = $type == 'blogView' ? 0:$to;
  mysqli_query($link, "INSERT INTO activity(activity_ip,activity_type,activity_to,activity_from,activity_time) VALUES ('$userIP','$type','$to','$from','$crTime')") or die(mysqli_error($link));
}

function post_comment($link,$comment){
  $fields = implode(', ', array_keys($comment));
  $values = '\'' . implode('\', \'',$comment) . '\'';
  if(!mysqli_query($link, "INSERT INTO comments($fields) VALUES ($values)")){
    return 'Unable to post comment';
  }else{
    make_it_count($link,'comment',$comment['post_access'],$comment['accessHash']);
    return 'Comment posted successfully';
  }
}

function get_comment_replies($link,$comment_id){
  $fields = array('comment_author_name','comment_author_email','comment_content','comment_parent','post_access', 'comment_type','comment_date_gmt');
  $fields = implode(', ',$fields);
  $res = mysqli_query($link,"SELECT $fields FROM comments WHERE comment_parent = '$comment_id' AND comment_type='reply' ORDER BY comment_date_gmt DESC");
  $replies = array();
  while($row = mysqli_fetch_assoc($res)){
    $reply = array();
    foreach($row as $key => $value){
      $reply[$key] = $value;
    }
    array_push($replies,$reply);
  }
  return $replies;
}

function get_comments($link, $hash, $limit){
  $limit = (int)$limit != 0 ? "LIMIT $limit":"";
  $fields = array('comment_author_name','comment_author_email','comment_content','comment_parent','post_access', 'comment_type','comment_date_gmt','accessHash');
  $fields = implode(', ',$fields);
  $res = mysqli_query($link,"SELECT $fields FROM comments WHERE post_access = '$hash' AND comment_type='comment' ORDER BY comment_date_gmt DESC $limit") or die(mysqli_error($link));
  $comments = array();
  while($row = mysqli_fetch_assoc($res)){
    $comment = array();
    foreach($row as $key => $value){
      $comment[$key] = $value;
    }
    $comment['replies'] = get_comment_replies($link, $row['accessHash']);
    array_push($comments,$comment);
  }
  return $comments;
}

function get_blog_content($link){
  $blog_data = array();
  $res = mysqli_query($link, "SELECT * FROM template_cache");
  while($row = mysqli_fetch_assoc($res)){
    $blog_data[$row['template_cache_name']] = $row['template_cache_value'];
  }
  make_it_count($link,'blogView','0','0');
  return $blog_data;
}

function get_specific_post($link,$accessHash){
  $accessHash = sanitize($link, $accessHash);
  $fields = array('post_title','post_content','post_date_gmt','post_excerpt','post_view_count','post_comment_count','post_share_count','post_category','post_tags','accessHash','post_name');
  $fields = implode(',',$fields);
  make_it_count($link,'postView',$accessHash,'0');
  $res = mysqli_fetch_assoc(mysqli_query($link, "SELECT $fields FROM posts WHERE post_status = 'publish' AND post_name='$accessHash' LIMIT 1"));
  $res['post_content'] = htmlspecialchars_decode($res['post_content']);
  return $res;
}

function get_posts($link, $limit){
  $limit = $limit != 0 ? "LIMIT $limit":"";
  $posts = array();
  $fields = array('post_id','post_title','post_content','post_date_gmt','post_excerpt','post_view_count','post_comment_count','post_share_count','post_category','post_tags','accessHash','post_name');
  $fields = implode(',',$fields);
  $res = mysqli_query($link, "SELECT $fields FROM posts WHERE post_status = 'publish' ORDER BY post_date_gmt ASC $limit");
  while($row = mysqli_fetch_assoc($res)){
    $row['post_content'] = htmlspecialchars_decode($row['post_content']);
    $post = array();
    foreach ($row as $key => $value) {
      $post[$key] = $value;
    }
    array_push($posts, $post);
  }
  return $posts;
}


$possible_url = array('getBlogContent','getBlogPosts','getSpecificPost','getComments','postComment','getBlogSettings');
$value = 'An error has occurred';

if(isset($_POST['privateAccess']) && $_POST['privateAccess'] == 'private_api_access'){
  if(isset($_GET['action']) && in_array($_GET['action'], $possible_url)){
    switch ($_GET['action']) {
      case 'getBlogContent':
        $value = get_blog_content($db_conx);
        break;

      case 'getSpecificPost':
        if(isset($_POST['hash']) && !empty($_POST['hash'])){
          $value = get_specific_post($db_conx, $_POST['hash']);
        }
        break;

      case 'getComments':
        $limit = 0;
        if(isset($_POST['limit']) && !empty($_POST['limit']))
          $limit = (int)$_POST['limit'];

        if(isset($_POST['hash']) && !empty($_POST['hash'])){
          $value = get_comments($db_conx, $_POST['hash'],$limit);
        }
        break;

      case 'getBlogSettings':
        $value = $settings;
        break;

      case 'postComment':
        if(isset($_POST) && !empty($_POST)){
          foreach ($_POST as $key => $value) {
            $comment[$key] = sanitize($db_conx, $value);
          }
          unset($comment['privateAccess']);
          if(!isset($comment['comment_author_email'])){
            $comment['comment_author_email'] = 'Anonymous';
          }
          if(!isset($comment['comment_author_name'])){
            $comment['comment_author_name'] = 'Anonymous';
          }
          $comment['comment_approved'] = ($settings['blog_comment_settings'] == 'public') ? 'public':'notapproved';
          $comment['comment_author_IP'] = getUserIP();
          $comment['accessHash'] = sha1("COMMENT".microtime());
          date_default_timezone_set('UTC');
          $comment['comment_date_gmt'] = date('Y-m-d H:i:s');
//          $value = $comment;
          $value = post_comment($db_conx, $comment);
        }
        break;

      case 'getBlogPosts':
        $count = 0;

        if(isset($_POST['postCount']) && !empty($_POST['postCount']))
          $count = (int)$_POST['postCount'];

        $value = get_posts($db_conx,$count);
        break;

      default:
        break;
    }
  }
}else {
  $value = 'No Access';
}
exit(json_encode($value));
?>
