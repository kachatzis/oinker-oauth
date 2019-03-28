<?php

  include 'utils/Redirect.php';
  include 'utils/Config.php';
  if($config['site_maintenance_mode']){
    require __DIR__ . $config['maintenance_url'];
    exit();
  }

  session_start();

  require 'utils/AltoRouter.php';

  // Initialize Router
  $router = new AltoRouter();

  // Select Timezone
  date_default_timezone_set($config['timezone']);

  // Create Paths
  $router->map( 'GET', '/authorize', function() {  require __DIR__ . '/views/Authorize.php'; }, 'Authorize_GET');
  $router->map( 'POST', '/authorize', function() {  require __DIR__ . '/views/Authorize.php'; }, 'Authorize_POST');
  
  // Match Routes and Load file
  $match = $router->match();
  if( $match && is_callable( $match['target'] ) ) {
	   call_user_func_array( $match['target'], $match['params'] );
  } else {
     require __DIR__ . '/views/error-404.php';
  }


?>
