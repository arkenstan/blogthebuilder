<?php

include 'init.php';

if(isset($_GET['act']) && !empty($_GET['act'])){

  switch((int)$_GET['act']){
    case 1:
      $ret = getCatalog($db_conx);
      header('Content-type: application/json');
      echo "{ \"themes\":[ $ret ] }";
      break;
    case 2:
      if(isset($_POST['theme_id']) && !empty($_POST['theme_id'])){
        if(!setNewTheme($db_conx,$_POST['theme_id'])){
          echo 'E|Failed to switch theme';
        }else{
          echo 'S|Successfully Changed Theme';
        }
        break;
      }
      break;
  }

}

function setNewTheme($link, $themeID){
  $res = mysqli_fetch_assoc(mysqli_query($link, "SELECT template_cache_location FROM template_catalog WHERE theme_id='$themeID' LIMIT 1"));


}

function getCatalog($link){
  $res = mysqli_query($link, "SELECT template_id,template_cache_location,template_name,theme_display,template_creator,template_active FROM template_catalog");
  $num = mysqli_num_rows($res);
  $ret = '';
  while($row = mysqli_fetch_assoc($res)){
    $ret .= '{';
    $i = count($row);
    foreach ($row as $key => $value) {
      $ret .= '"'.$key.'":"'.$value.'"';
      if(--$i > 0) $ret .= ',';
    }
    $ret .= '}';
    if(--$num > 0) $ret .= ',';
  }
  return $ret;
}

?>
