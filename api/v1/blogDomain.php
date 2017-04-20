<?php

include 'init.php';

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

?>
