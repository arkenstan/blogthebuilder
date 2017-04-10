<?php

include 'init.php';
if(isset($_GET['act']) && !empty($_GET['act'])){
  switch ((int)$_GET['act']) {
    case 1:
      $post_data = get_post_input($db_conx);
      date_default_timezone_set('UTC');
      $post_data['post_date_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_modified_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_status'] = 'publish';
      $post_data['post_name'] = $post_data['post_url'];
      unset($post_data['post_url']);
      $post_data['post_user'] = $user_data['user_id'];
      if(category_exists($db_conx, $post_data['post_category']) == false){
        mysqli_query($db_conx,"INSERT INTO categories(category_name) VALUES('".$post_data['post_category']."')");
      }else{
        mysqli_query($db_conx,"UPDATE categories SET category_popularity = category_popularity+1 WHERE category_name = '".$post_data['post_category']."'");
      }
      $fields = implode(', ', array_keys($post_data));
      $values = '\'' . implode('\', \'', $post_data) . '\'';

      if(!mysqli_query($db_conx, "INSERT into posts($fields) VALUES($values)")){
        echo 'E|Failed to connect to database';
      }else{
        echo 'S|Post successfully Published';
      }
      break;
    case 2:
      $postID = ''; ///// CALL THE POST FUNCTION FOR SINGLE VALUE
      if(!mysqli_query($db_conx,"UPDATE posts SET post_status='draft' WHERE post_id=$postID")){
        echo 'E|Failed to make updation';
      }else{
        echo 'S|Post Updated to draft';
      }
      break;
    case 3:
      $postID = ''; ///// CALL THE POST FUNCTION FOR SINGLE VALUE
      if(!mysqli_query($db_conx,"UPDATE posts SET post_status='unpublish' WHERE post_id=$postID")){
        echo 'E|Failed to make updation';
      }else{
        echo 'S|Post Updated to Unpublished';
      }
      break;
    case 4:
      break;
    case 5:
      $postID = ''; ///// CALL THE POST FUNCTION FOR SINGLE VALUE
      if(!mysqli_query($db_conx,"UPDATE posts SET post_status='deleted' WHERE post_id=$postID")){
        echo 'E|Failed to make updation';
      }else{
        echo 'S|Post Deleted';
      }
      break;

    default:
      break;
  }
}else{
  echo 'Invalid Operation';
}

function get_post_input($link){
  $post = json_decode(file_get_contents('php://input'));
  $post_data = array();
  foreach ($post as $key => $value) {
    $post_data[$key] = sanitize($link, $value);
  }
  return $post_data;
}
?>
