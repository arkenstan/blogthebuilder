<?php

include 'init.php';

if(logged_in() == false){
  exit('Unable to access');
}

$possibilities = 6;


if(isset($_GET['act']) && !empty($_GET['act']) && (int)$_GET['act'] <= $possibilities){
  switch ((int)$_GET['act']) {
    case 1:
      $post_data = get_post_input($db_conx);
      if(postUrlExists($db_conx, $post_data['post_url']) == true){
        echo 'Post url already Exists Please';
        break;
      }
      date_default_timezone_set('UTC');
      $post_data['post_date_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_modified_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_status'] = 'publish';
      $post_data['post_name'] = $post_data['post_url'];
      unset($post_data['post_url']);
      $post_data['post_user'] = $user_data['user_id'];
      if(makeCategory($db_conx, $post_data['post_category'],1) == false){
        echo 'Failed to set Category. Please check your network connection';
        break;
      }
      $post_data['accessHash'] = sha1("POST ".microtime());
      $fields = implode(', ', array_keys($post_data));
      $values = '\'' . implode('\', \'', $post_data) . '\'';

      if(!mysqli_query($db_conx, "INSERT into posts($fields) VALUES($values)")){
        echo 'Failed to connect to database';
      }else{
        echo 'Post successfully Published';
      }
      break;
    case 2:
      $post_data = get_post_input($db_conx);
      if(postUrlExists($db_conx, $post_data['post_url']) == true){
        echo 'Post url already Exists Please';
        break;
      }
      date_default_timezone_set('UTC');
      $post_data['post_date_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_modified_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_status'] = 'draft';
      $post_data['post_name'] = $post_data['post_url'];
      unset($post_data['post_url']);
      $post_data['post_user'] = $user_data['user_id'];
      if(makeCategory($db_conx, $post_data['post_category'],0) == false){
        echo 'Failed to set Category. Please check your network connection';
        break;
      }
      $post_data['accessHash'] = sha1("POST ".microtime());
      $fields = implode(', ', array_keys($post_data));
      $values = '\'' . implode('\', \'', $post_data) . '\'';

      if(!mysqli_query($db_conx, "INSERT into posts($fields) VALUES($values)")){
        echo 'Failed to connect to database';
      }else{
        echo 'Post Added to Draft';
      }
      break;
    case 3:
      if(isset($_POST['category']) && !empty($_POST['category'])){
        $cate = sanitize($db_conx, $_POST['category']);
        $res = mysqli_query($db_conx, "SELECT * FROM posts WHERE post_status = '$cate'");
        $num = mysqli_num_rows($res);
        $ret = '';
        $posts = array(
          'posts' => array()
        );
        if($num != 0){
          while($row = mysqli_fetch_assoc($res)){
            $post = array();
            $row['post_content'] = htmlspecialchars_decode($row['post_content']);
            foreach ($row as $key => $value) {
              $post[$key] = $value;
            }
            array_push($posts['posts'],$post);
          }
        }
        echo json_encode($posts);
      }
      break;
    case 4:
      $post = get_post_input($db_conx);
      $postID = $post['post_id'];
      if(makeCategory($db_conx,$post['post_category'],0) == false){
        echo 'Unable to connect to Database 1';
        break;
      }
      date_default_timezone_set('UTC');
      $post['post_modified_gmt'] = date('Y-m-d H:i:s');
      $dontUpdate = array('post_id','post_date_gmt','post_name','post_view_count','post_comment_count','post_share_count','post_user','post_content_original');
      foreach ($post as $key => $value) {
        if(!in_array($key, $dontUpdate)){
          $value = "'$value'";
          $updates[] = "$key=$value";
        }
      }
      $updates = implode(', ',$updates);
      if(!mysqli_query($db_conx, "UPDATE posts SET $updates WHERE post_id=$postID")){
        echo 'Unable to Connect to Database';
      }else{
        echo 'successfully updated post';
      }
      break;
    case 5:
      if(isset($_POST['post_id']) && !empty($_POST['post_id'])){
        $id = (int)$_POST['post_id'];
        if(!mysqli_query($db_conx, "UPDATE posts SET post_status = 'draft' WHERE post_id='$id'")){
          echo 'Unable to update';
        }else{
          echo 'Post Added to draft';
        }
      }
      break;
    case 6:
      if(isset($_POST['post_id']) && !empty($_POST['post_id'])){
        $id = (int)$_POST['post_id'];
        if(!mysqli_query($db_conx, "UPDATE posts SET post_status = 'delete' WHERE post_id='$id'")){
          echo 'Unable to update';
        }else{
          echo 'Post Deleted';
        }
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
