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



function post_reply($link, $data){
  $fields = implode(', ',array_keys($data));
  $values = '\'' . implode('\', \'', $data) . '\'';
  mysqli_query($link,"INSERT INTO comments($fields) VALUES($values)");
  mysqli_query($link,"INSERT INTO activity(activity_ip,activity_type,activity_to,activity_from,activity_time) VALUES('admin','comment','".$data['post_access']."','".$data['accessHash']."')");
  return 'Successfully replied';
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
      if(isset($_POST) && !empty($_POST)){
        foreach ($_POST as $key => $value) {
          $reply[$key] = sanitize($db_conx, $value);
        }
        $reply['comment_author_email'] = 'Admin';
        $reply['comment_author_name'] = 'Admin';
        $reply['comment_author_IP'] = 'Admin';
        $reply['comment_approved'] = 'public';
        date_default_timezone_set('UTC');
        $reply['comment_date_gmt'] = date('Y-m-d H:i:s');
        $reply['accessHash'] = sha1("COMMENT".microtime());
        $value = post_reply($db_conx, $reply);
      }
      break;

    default:
      # code...
      break;
  }

}

exit(json_encode($value));


?>
