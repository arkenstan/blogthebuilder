<?php

include 'init.php';
if(isset($_GET['act']) && !empty($_GET['act'])){
  switch ((int)$_GET['act']) {
    case 1:
      $post_data = get_post_input($db_conx);
      if(postUrlExists($db_conx, $post_data['post_url']) == true){
        echo 'E|PU|Post url already Exists Please';
        break;
      }
      date_default_timezone_set('UTC');
      $post_data['post_date_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_modified_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_status'] = 'publish';
      $post_data['post_name'] = $post_data['post_url'];
      unset($post_data['post_url']);
      $post_data['post_user'] = $user_data['user_id'];
      if(category_exists($db_conx, $post_data['post_category']) == false){
        if(!mysqli_query($db_conx,"INSERT INTO categories(category_name) VALUES('".$post_data['post_category']."')")){
          echo 'E|A|Failed to set Category. Please check your network connection';
          break;
        }
      }else{
        if(!mysqli_query($db_conx,"UPDATE categories SET category_popularity = category_popularity+1 WHERE category_name = '".$post_data['post_category']."'")){
          echo 'E|A|Failed to update Category. Please check your network connection';
          break;
        }
      }
      $fields = implode(', ', array_keys($post_data));
      $values = '\'' . implode('\', \'', $post_data) . '\'';

      if(!mysqli_query($db_conx, "INSERT into posts($fields) VALUES($values)")){
        echo 'E|A|Failed to connect to database';
      }else{
        echo 'S|Post successfully Published';
      }
      break;
    case 2:
      $post_data = get_post_input($db_conx);
      if(postUrlExists($db_conx, $post_data['post_url']) == true){
        echo 'E|PU|Post url already Exists Please';
        break;
      }
      date_default_timezone_set('UTC');
      $post_data['post_date_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_modified_gmt'] = date('Y-m-d H:i:s');
      $post_data['post_status'] = 'draft';
      $post_data['post_name'] = $post_data['post_url'];
      unset($post_data['post_url']);
      $post_data['post_user'] = $user_data['user_id'];
      if(category_exists($db_conx, $post_data['post_category']) == false){
        if(!mysqli_query($db_conx,"INSERT INTO categories(category_name) VALUES('".$post_data['post_category']."')")){
          echo 'E|A|Failed to set Category. Please check your network connection';
          break;
        }
      }else{
        if(!mysqli_query($db_conx,"UPDATE categories SET category_popularity = category_popularity+1 WHERE category_name = '".$post_data['post_category']."'")){
          echo 'E|A|Failed to update Category. Please check your network connection';
          break;
        }
      }
      $fields = implode(', ', array_keys($post_data));
      $values = '\'' . implode('\', \'', $post_data) . '\'';

      if(!mysqli_query($db_conx, "INSERT into posts($fields) VALUES($values)")){
        echo 'E|A|Failed to connect to database';
      }else{
        echo 'S|Post Added to Draft';
      }
      break;
    case 3:
      if(isset($_POST['category']) && !empty($_POST['category'])){
        $cate = sanitize($db_conx, $_POST['category']);
        $res = mysqli_query($db_conx, "SELECT * FROM posts WHERE post_status = '$cate'");
        $num = mysqli_num_rows($res);
        $ret = '';
        if($num != 0){
          while($post = mysqli_fetch_assoc($res)){
            $post['post_content'] = htmlspecialchars_decode($post['post_content']);
  //          $post['post_date_gmt'] = new DateTime($post['post_date_gmt']);
            $len = count($post);
            $ret .= '{';
            foreach ($post as $key => $value) {
              $ret .= '"'.$key.'":"'.$value.'"';
              if(--$len > 0) $ret .= ',';
            }
            $ret .= '}';
            if(--$num > 0) $ret .= ',';
          }
          $ret = '"posts":['.$ret.']';
        }
        header('Content-type: application/json');
        echo "{ $ret }";
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
