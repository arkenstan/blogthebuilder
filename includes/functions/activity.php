<?php

include 'init.php';

function get_view_growth($link){
  $res = mysqli_fetch_assoc(mysqli_query($link,"SELECT activity_id FROM activity WHERE activity_type='workspace' ORDER BY activity_time DESC LIMIT 1"));
  $res = empty($res['activity_id']) ? 0:$res['activity_id'];
  $prev = mysqli_num_rows(mysqli_query($link, "SELECT activity_id FROM activity WHERE (activity_type='blogView' OR activity_type='postView') AND activity_id < $res"));
  $new = mysqli_num_rows(mysqli_query($link, "SELECT activity_id FROM activity WHERE (activity_type='blogView' OR activity_type='postView') AND activity_id > $res"));
  $prev = $prev == 0 ? $new:$prev;
  $growth = ($new / $prev)*100;
  return $growth;
}

function get_popularity_growth($link){
  $res = mysqli_fetch_assoc(mysqli_query($link,"SELECT activity_id FROM activity WHERE activity_type='workspace' ORDER BY activity_time DESC LIMIT 1"));
  $res = empty($res['activity_id']) ? 0:$res['activity_id'];
  $prev = mysqli_num_rows(mysqli_query($link, "SELECT activity_id FROM activity WHERE activity_id < $res"));
  $new = mysqli_num_rows(mysqli_query($link, "SELECT activity_id FROM activity WHERE activity_id > $res"));
  $prev = $prev == 0 ? $new:$prev;
  $growth = ($new / $prev)*100;
  return $growth;
}

function get_activity_data($link, $type, $scale){
  if($scale == 'day'){
    $groupby = 'DAY(activity_time)';
    $fetch = 'DAYNAME(activity_time)';
  }else if($scale == 'month'){
    $groupby = 'MONTH(activity_time)';
    $fetch = 'MONTHNAME(activity_time)';
  }else if($scale == 'year'){
    $groupby = 'YEAR(activity_time)';
  }
  $res = mysqli_query($link, "SELECT COUNT(activity_id) AS views,$fetch AS scale FROM activity WHERE activity_type='$type' GROUP BY $groupby");
  $data_set = array();
  while($row = mysqli_fetch_assoc($res)){
    $data = array();
    foreach ($row as $key => $value) {
      $data[$key] = $value;
    }
    array_push($data_set,$data);
  }
  return $data_set;
}

function get_initial_data($link){
  $data = array();

  $data['post_count'] = mysqli_num_rows(mysqli_query($link, "SELECT post_id FROM posts"));
  $data['comment_count'] = mysqli_num_rows(mysqli_query($link, "SELECT comment_id FROM comments"));
  $data['view_growth'] = get_view_growth($link);
  $data['popularity_growth'] = get_popularity_growth($link);

  return $data;
}


$possible_url = array('initialData', 'activityChart');
$value = 'An error occurred';

if(isset($_GET['action']) && in_array($_GET['action'], $possible_url)){

  switch ($_GET['action']) {
    case 'initialData':
      $value = get_initial_data($db_conx);
      break;

    case 'activityChart':
      $type = isset($_POST['type']) ? sanitize($db_conx, $_POST['type']) : 'blogView';
      $scale = isset($_POST['scale']) ? sanitize($db_conx, $_POST['scale']) : 'date';
      $value = get_activity_data($db_conx, $type, $scale);
      break;

    default:
      break;
  }

}

exit(json_encode($value));

?>
