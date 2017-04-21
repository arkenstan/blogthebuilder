<?php

include 'init.php';

function make_it_count($link,$type,$to){
  $userIP = getUserIP();
  date_default_timezone_set('UTC');
  $crTime = date('Y-m-d H:i:s');
  if($type == 'postView'){
    mysqli_query($link, "UPDATE posts SET post_view_count = post_view_count+1 WHERE accessHash='$to'") or die(mysqli_error($link));
  }
  $to = $type == 'blogView' ? 0:$to;
  mysqli_query($link, "INSERT INTO activity(activity_ip,activity_type,activity_to,activity_time) VALUES ('$userIP','$type','$to','$crTime')") or die(mysqli_error($link));
}


function get_blog_content($link){
  $blog_data = array();
  $res = mysqli_query($link, "SELECT * FROM template_cache");
  while($row = mysqli_fetch_assoc($res)){
    $blog_data[$row['template_cache_name']] = $row['template_cache_value'];
  }
  make_it_count($link,'blogView','0');
  return $blog_data;
}

function get_posts($link, $limit){
  $limit = $limit != 0 ? "LIMIT $limit":"";
  $posts = array();
  $fields = array('post_title','post_content','post_date_gmt','post_excerpt','post_view_count','post_comment_count','post_share_count','post_category','post_tags','accessHash');
  $fields = implode(',',$fields);
  $res = mysqli_query($link, "SELECT $fields FROM posts WHERE post_status = 'publish' ORDER BY post_date_gmt ASC $limit");
  while($row = mysqli_fetch_assoc($res)){
    make_it_count($link, 'postView', $row['accessHash']);
    $post = array();
    foreach ($row as $key => $value) {
      $post[$key] = $value;
    }
    array_push($posts, $post);
  }
  return $posts;
}


$possible_url = array('getBlogContent','getBlogPosts');
$value = 'An error has occurred';

if(isset($_POST['privateAccess']) && $_POST['privateAccess'] == 'private_api_access'){
  if(isset($_GET['action']) && in_array($_GET['action'], $possible_url)){
    switch ($_GET['action']) {
      case 'getBlogContent':
        $value = get_blog_content($db_conx);
        break;

      case 'getBlogPosts':
        $value = 'Flag 1';
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
/*
if(isset($_GET) && !empty($_GET)){
  if(isset($_GET['pleaseThrow'])){
    switch($_GET['pleaseThrow']){
      case 'theme':
        $ret = getThemeData($db_conx);
        header('Content-type: application/json');
        echo $ret;
        break;
      case 'blogcontentall':
        $ret = get_blog_content($db_conx);
        $ret .= ',"posts":['.get_posts($db_conx) . ']';
        header('Content-type: application/json');
        echo "{ $ret }";
        break;
      case 'blogcontent':
        header('Content-type: application/json');
        echo '{' .get_blog_content($db_conx) . '}';
        break;
      case 'posts':
        header('Content-type: application/json');
        echo '{"posts":['.get_posts($db_conx).']}';
        break;
      default:
        break;
    }
  }else if(isset($_GET['postView']) && !empty($_GET['postView'])){
      $post_name = sanitize($db_conx, $_GET['postView']);
      $sp = getSpecificPost($db_conx,$post_name);
      if($sp != 'E'){
        header('Content-type: application/json');
        echo $sp;
      }else{
        echo 'E';
      }
  }else if(isset($_GET['pleaseUpdate']) && isAuthenticated() == true){
    switch($_GET['pleaseUpdate']){
      case 'incView':
        incrementing($db_conx, 'view');
        break;
      case 'postComment':
        post_comment($link);
        break;
    }
  }
}


function getSpecificPost($link,$post_name){
  $res = mysqli_query($link,"SELECT * FROM posts WHERE post_name='$post_name' LIMIT 1");
  $ret = '';
  while($row = mysqli_fetch_assoc($res)){
    $i = count($row);
    $row['post_content'] = htmlspecialchars_decode($row['post_content']);
    foreach ($row as $key => $value) {
      $ret .= '"'.$key.'":"'.$value.'"';
      if(--$i > 0) $ret .= ',';
    }
  }
  return $ret != '' ? "{ $ret }" : 'E';
}

function get_blog_content($link){
  $res = mysqli_query($link,"SELECT * FROM template_cache");
  $num = mysqli_num_rows($res);
  $ret = '';
  while($row = mysqli_fetch_assoc($res)){
    $ret .= '"'.$row['template_cache_name'].'":"'.$row['template_cache_value'].'"';
    if(--$num > 0) $ret .= ',';
  }
  return $ret;
}

function getThemeData($link){
  $res = mysqli_fetch_assoc(mysqli_query($link, "SELECT template_name,template_creator,template_cache_location FROM template_catalog WHERE template_active='yes' LIMIT 1"));
  $ret = '"template_name":"'.$res['template_name'].'",';
  $ret .= '"template_creator":"'.$res['template_creator'].'",';
  $ret .= '"template_cache_location":"'.$res['template_cache_location'].'"';
  return "{ $ret }";
}

function get_posts($link){
  $res = mysqli_query($link, "SELECT * FROM posts WHERE post_status='publish'");
  $num = mysqli_num_rows($res);
  $ret = '';
  while($row = mysqli_fetch_assoc($res)){
    $ret .= '{';
    $i = count($row);
    $row['post_content'] = htmlspecialchars_decode($row['post_content']);
    foreach($row as $key => $value){
      $ret .= '"'.$key.'":"'.$value.'"';
      if(--$i > 0) $ret .= ',';
    }
    $ret .= '}';
    if(--$num > 0) $ret .= ',';
  }
  return $ret;
}
*/
?>
