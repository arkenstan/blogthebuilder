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
  $res = mysqli_query($link,"SELECT $fields FROM comments WHERE post_access = '$hash' AND comment_approved='public' AND comment_type='comment' ORDER BY comment_date_gmt DESC $limit") or die(mysqli_error($link));
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

function get_blog_settings_new($link){
  $res = mysqli_query($link, "SELECT settings_name,settings_value FROM settings") or die(mysqli_error($link));
  $settings = array();
  while($row = mysqli_fetch_assoc($res)){
    $settings[$row['settings_name']] = $row['settings_value'];
  }
  return $settings;
}

function get_blog_content_new($link){
  $res = mysqli_query($link, "SELECT template_cache_name,template_cache_value FROM template_cache") or die(mysqli_error($link));
  $settings = array();
  while($row = mysqli_fetch_assoc($res)){
    $settings[$row['template_cache_name']] = $row['template_cache_value'];
  }
  if($settings['home_page_disabled'] == 'true'){
    $disable = array('home_content','home_title');
    foreach($disable as $key => $value){
      unset($settings[$value]);
    }
  }
  if($settings['about_page_disabled'] == 'true'){
    $disable = array('about_content','about_title');
    foreach($disable as $key => $value){
      unset($settings[$value]);
    }
  }
  return $settings;
}

function get_blog_plugins($link){
  $fields = array('plugin_name','plugin_cache_location','plugin_creator','plugin_selected','plugin_access');
  $fields = implode(', ',$fields);
  $res = mysqli_query($link, "SELECT $fields FROM plugin_catalog");
  $plugins = array();
  while($row = mysqli_fetch_assoc($res)){
    $plugin['name'] = $row['plugin_name'];
    $plugin['cache'] = $row['plugin_cache_location'];
    $plugin['creator'] = $row['plugin_creator'];
    $plugin['active'] = $row['plugin_selected'];
    $plugin['access'] = $row['plugin_access'];
    $plugins[$row['plugin_cache_location']] = $plugin;
  }
  return $plugins;
}

function get_all_blog_content($link){
  $blogData = array();
  $content = get_blog_content_new($link);
  $settings = get_blog_settings_new($link);
  $plugins='No Plugins';
  if($content['plugin_disabled'] == 'false'){
    $plugins = get_blog_plugins($link);
  }
  $blogData['settings'] = $settings;
  $blogData['plugins'] = $plugins;
  $blogData['content'] = $content;
  return $blogData;
}


$possible_url = array('getBlogContent','getBlogPosts','getSpecificPost','getComments','postComment','getBlogSettings','blogContent');
$value = 'An error has occurred';

if(isset($_POST['privateAccess']) && $_POST['privateAccess'] == 'private_api_access'){
  if(isset($_GET['action']) && in_array($_GET['action'], $possible_url)){
    switch ($_GET['action']) {
      case 'blogContent':
        $value = get_all_blog_content($db_conx);
        break;

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
          $comment['comment_approved'] = ($settings['blog_comment_moderation'] == 'never') ? 'public':'notapproved';
          $comment['comment_author_IP'] = getUserIP();
          $comment['accessHash'] = sha1("COMMENT".microtime());
          date_default_timezone_set('UTC');
          $comment['comment_date_gmt'] = date('Y-m-d H:i:s');
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
