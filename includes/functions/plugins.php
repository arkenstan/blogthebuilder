<?php

include 'init.php';

if(logged_in() == false){
  exit("Unable to connect");
}


function get_plugins($link){
  $res = mysqli_query($link, "SELECT * FROM plugin_catalog");
  $plugins = array();
  while($row = mysqli_fetch_assoc($res)){
    $plugin = array();
    foreach ($row as $key => $value) {
      $plugin[$key] = $value;
    }
    array_push($plugins,$plugin);
  }
  return $plugins;
}

function update_Plugins($link, $data){
  for($i=0;$i<count($data);++$i){
    $plugin_id = $data[$i]['plugin_id'];
    $plugin_selected = $data[$i]['plugin_selected'];
    if(!mysqli_query($link, "UPDATE plugin_catalog SET plugin_selected = '$plugin_selected' WHERE plugin_id = '$plugin_id'")){
      return 'Unable to update';
    }
  }
  return 'Updated';
}

$possibleUrl = array('getPlugins','updateChanges');
$value = 'An Error Occurred';

if(isset($_GET['action']) && in_array($_GET['action'], $possibleUrl)){

  switch ($_GET['action']) {
    case 'getPlugins':
      $value = get_plugins($db_conx);
      break;

    case 'updateChanges':
      $data = json_decode(file_get_contents('php://input'));
      $postUpdate = array();
      $valuable = array('plugin_id','plugin_active');
      for ($i=0; $i < count($data); $i++) {
        $postUpdate[$i]['plugin_id'] = $data[$i]->plugin_id;
        $postUpdate[$i]['plugin_selected'] = $data[$i]->plugin_selected;
      }
      $value = update_Plugins($db_conx,$postUpdate);
      break;

    default:
      # code...
      break;
  }

}

exit(json_encode($value));
?>
