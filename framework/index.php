<?php

  try {
    require_once('init.php');
    
  	// sanitize user input
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    
    // route is contained in URL's "path" parameter (which is rewritten by htaccess)
    Router::route($_GET['path']);
  }
  catch (Exception $e) {
    Logger::error($e->getMessage());
    // display error message while in testing mode
    if (Settings::get('useTestMode')) {
      echo 'Exception: ' . $e->getMessage();
    }
  }
	
?>