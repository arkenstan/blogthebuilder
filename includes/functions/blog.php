<?php

include_once 'init.php';

if(isset($_GET['act']) && !empty($_GET['act'])){
  switch ((int)$_GET['act']) {
    case 1:
      $ret = '';
      if(!$res = mysqli_query($db_conx, "SELECT * FROM settings")){
        echo 'E|Can\'t connect to database';
        break;
      }
      $num = mysqli_num_rows($res);
      while($row = mysqli_fetch_assoc($res)){
        $ret .= '"'.$row['settings_name'].'":"'.$row['settings_value'].'"';
        if(--$num > 0) $ret .= ',';
      }
      header('Content-type: application/json');
      echo "{ $ret }";
      break;
    case 2:
      break;
    case 3:
      $ret = '';
      if(!$res = mysqli_query($db_conx, "SELECT * FROM timezones")){
        echo 'E|Can\'t connect to database';
        break;
      }
      $num = mysqli_num_rows($res);
      while($row = mysqli_fetch_assoc($res)){
        $ret = '{"TZ_offset":"'.$row['time_zone_offset'].'", "TZ_represent":"'.$row['time_zone_resprestation'].'", "TZ_name":"'.$row['time_zone_name'].'"}';
        if(--$num > 0) $ret .= ',';
      }
      $ret = '"timezones":[ '.$ret.' ]';
      header('Content-type: application/json');
      echo "{ $ret }";
      break;
    case 4:
      $ret = '';
      if(!$res = mysqli_query($db_conx, "SELECT * FROM locale")){
        echo 'E|Can\'t connect to database';
        break;
      }
      $num = mysqli_num_rows($res);
      while($row = mysqli_fetch_assoc($res)){
        $ret = '{"locale_name":"'.$row['locale_name'].'", "locale_code":"'.$row['locale_code'].'"}';
        if(--$num > 0) $ret .= ',';
      }
      $ret = '"locales":[ '.$ret.' ]';
      header('Content-type: application/json');
      echo "{ $ret }";
      break;
    default:
      break;
  }
}

?>
