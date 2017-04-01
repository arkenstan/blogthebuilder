<?php

  session_id('vader');
  session_start();
  session_destroy();
  session_commit();

?>
