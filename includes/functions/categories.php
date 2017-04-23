<?php

include 'init.php';

if(logged_in() == false){
  exit('Unable to access');
}

$possibilities = 6;


if(isset($_GET['act']) && !empty($_GET['act']) && (int)$_GET['act'] <= $possibilities){
  switch((int)$_GET['act']){
    case 1:
      $cate = '';
      if(isset($_POST['cate']) && !empty($_POST['cate'])){
        $cate = sanitize($db_conx, $_POST['cate']);
      }
      $sql = mysqli_query($db_conx, "SELECT * FROM categories WHERE category_name LIKE '%$cate%'");
      $num = mysqli_num_rows($sql);
      $ret = '';
      while($row = mysqli_fetch_assoc($sql)){
        $i = 0;
        $ret .= '{';
        foreach ($row as $key => $value) {
          $ret .= '"'.$key.'":"'.$value.'"';
          if(++$i < 3)  $ret .= ',';
        }
        $ret .= '}';
        if(--$num > 0) $ret .= ',';
      }
      $ret = '"categories":['.$ret.']';
      header('Content-type: application/json');
      echo '{'.$ret.'}';
      break;
  }
}

?>
