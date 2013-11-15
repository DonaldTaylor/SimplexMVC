<?php

  require_once('init.php');
  
  if ($_GET['confirmed'] !== 'true') {
    // prompt user for confirmation before proceeding
    echo '<a href="?confirmed=true">Install Database Tables</a>. This will purge the tables and all of their data!';
  }
  else {
    // install database tables
    echo "Attempting to install tables . . . \n";
    try {
      $db = new Database;
      // find and run SQL table installation files
      $sqlDirectory = ROOT . 'sql/';
      foreach (scandir($sqlDirectory) as $file) {
        if (!is_dir($file) && strstr($file, '.sql')) {
          // initialize class
          $query = file_get_contents($sqlDirectory . $file);
          $db->query($query);
        }
      }
    }
    catch (Exception $e) {
      die($e->getMessage());
    }
    echo 'Installation completed successfully.';
  }
  
?>