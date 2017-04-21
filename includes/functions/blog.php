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
      $settings = json_decode(file_get_contents('php://input'));
      foreach ($settings as $key => $value) {
        $settingsData[$key] = sanitize($db_conx, $value);
      }
      foreach ($settings as $key => $value) {
        $sql = "UPDATE settings SET settings_value='$value' WHERE settings_name='$key'";
        mysqli_query($db_conx, $sql) or die(mysqli_error($db_conx));
      }
      break;
    case 3:
      $ret = '';
      if(!$res = mysqli_query($db_conx, "SELECT * FROM timezones")){
        echo 'E|Can\'t connect to database';
        break;
      }
      $num = mysqli_num_rows($res);
      while($row = mysqli_fetch_assoc($res)){
        $ret .= '{"TZ_offset":"'.$row['time_zone_offset'].'", "TZ_represent":"'.$row['time_zone_representation'].'", "TZ_name":"'.$row['time_zone_name'].'"}';
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
        $ret .= '{"locale_name":"'.$row['locale_name'].'", "locale_code":"'.$row['locale_code'].'"}';
        if(--$num > 0) $ret .= ',';
      }
      $ret = '"locales":[ '.$ret.' ]';
      header('Content-type: application/json');
      echo "{ $ret }";
      break;
    case 5:
      $ret = '';
      $res = mysqli_query($db_conx, "SELECT * FROM template_cache");
      $num = mysqli_num_rows($res);
      while ($row = mysqli_fetch_assoc($res)) {
        $ret .= '"'.$row['template_cache_name'].'":"'.$row['template_cache_value'].'"';
        if(--$num > 0) $ret .= ',';
      }
      header('Content-type: application/json');
      echo "{ $ret }";
      break;
    case 6:
      $data = json_decode(file_get_contents('php://input'));
      foreach($data as $key => $value){
        $key = sanitize($db_conx, $key);
        $value = sanitize($db_conx, $value);
        if(!mysqli_query($db_conx, "UPDATE template_cache SET template_cache_value='$value' WHERE template_cache_name='$key'")){
          echo 'E|Can\'t Make Updates';
          break;
        }
      }
      echo 'S|All Changes Successfully Made';
      break;
    default:
      break;
  }
}

?>
