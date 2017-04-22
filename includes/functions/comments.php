<?php

include 'init.php';

function get_replies($link,$parent){
  $fields = array('comment_author_name','comment_author_email','comment_content','comment_parent','post_access', 'comment_type','comment_date_gmt');
  $fields = implode(', ',$fields);
  $res = mysqli_query($link,"SELECT $fields FROM comments WHERE comment_parent = '$parent' AND comment_type='reply' ORDER BY comment_date_gmt DESC");
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

function get_comments($link,$hash){
  $fields = array('comment_author_name','comment_author_email','comment_content','comment_parent','post_access', 'comment_type','comment_date_gmt','accessHash');
  $fields = implode(', ',$fields);
  $res = mysqli_query($link,"SELECT $fields FROM comments WHERE post_access = '$hash' AND comment_type='comment' ORDER BY comment_date_gmt DESC") or die(mysqli_error($link));
  $comments = array();
  while($row = mysqli_fetch_assoc($res)){
    $comment = array();
    foreach($row as $key => $value){
      $comment[$key] = $value;
    }
    $comment['replies'] = get_replies($link, $row['accessHash']);
    array_push($comments,$comment);
  }
  return $comments;
}


$possible_urls = array('getComments','postComment');
$value = 'An error has occured';

if(isset($_GET['action']) && in_array($_GET['action'], $possible_urls)){

  switch ($_GET['action']) {
    case 'getComments':
      if(isset($_POST['post_access']) && !empty($_POST['post_access'])){
        $hash = sanitize($db_conx, $_POST['post_access']);
        $value = get_comments($db_conx, $hash);
      }
      break;
    case 'postComment':
      break;

    default:
      # code...
      break;
  }

}

exit(json_encode($value));


?>
