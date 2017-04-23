<?php

include 'init.php';

function get_desc_comment($link, $from, $to){
  $retString = 'posted a';
  $res = mysqli_fetch_assoc(mysqli_query($link, "SELECT comment_author_email,comment_author_name,comment_type FROM comments WHERE accessHash='$from' LIMIT 1"));
  $retString = $res['comment_author_email'].' ';
  if($res['comment_type'] == 'reply')
    $retString .= ' replied to a comment on ';
  else
    $retString .= ' comment on ';
  $res2 = mysqli_fetch_assoc(mysqli_query($link, "SELECT post_title FROM posts WHERE accessHash = '$to' LIMIT 1"));
  $retString .= $res2['post_title'];
  return $retString;
}

function get_desc_post($link, $to){
  $res2 = mysqli_fetch_assoc(mysqli_query($link, "SELECT post_title FROM posts WHERE post_name = '$to' LIMIT 1"));
  $retString = 'viewed '.$res2['post_title'];
  return $retString;
}

function get_trends($link, $limit){
  $res = mysqli_query($link, "SELECT * FROM activity WHERE activity_type <> 'workspace' ORDER BY activity_time DESC $limit");
  $trends = array();
  while($row = mysqli_fetch_assoc($res)){
    $trend = array();
    $trend['IP'] = $row['activity_ip'];
    $trend['TIME'] = $row['activity_time'];
    if($row['activity_type'] == 'comment'){
      $trend['TYPE'] = 'Comment';
      $trend['description'] = get_desc_comment($link, $row['activity_from'], $row['activity_to']);
    }else if($row['activity_type'] == 'postView'){
      $trend['TYPE'] = 'Post Viewed';
      $trend['description'] = get_desc_post($link, $row['activity_to']);
    }else{
      $trend['TYPE'] = 'Blog Viewed';
      $trend['description'] = "Viewed Your Blog";
    }
    array_push($trends, $trend);
  }
  return $trends;
}

$possible_url = array('getTrends');
$value = 'An error occurred';

if(isset($_GET['action']) && in_array($_GET['action'], $possible_url)){

  switch ($_GET['action']) {
    case 'getTrends':
      $limit = isset($_POST['limit']) ? "LIMIT ".(int)$_POST['limit']:'LIMIT 10';
      $value = get_trends($db_conx, $limit);
      break;

    default:
      # code...
      break;
  }

}

exit(json_encode($value));
?>
