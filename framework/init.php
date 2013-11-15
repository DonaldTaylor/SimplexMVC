<?php

  define('ROOT', '' . dirname(__FILE__) . '/../');

  // settings
  require_once(ROOT . 'settings.php');
  date_default_timezone_set(Settings::get('timeZone'));
  ini_set('display_errors', Settings::get('useTestMode'));
  
  // automatically and lazily load class files
  function __autoload($className) {
    $className = str_replace('\\', '', $className);
    if (file_exists(ROOT . 'framework/' . $className . '.php')) {
      require_once(ROOT . 'framework/' . $className . '.php');
    }
    else if (file_exists(ROOT . 'vendor/' . $className . '.php')) {
      require_once(ROOT . 'vendor/' . $className . '.php');
    }
    else if (file_exists(ROOT . 'models/' . $className . '.php')) {
      require_once(ROOT . 'models/' . $className . '.php');
    }
    else if (file_exists(ROOT . 'controllers/' . $className . '.php')) {
      require_once(ROOT . 'controllers/' . $className . '.php');
    }
    else if (file_exists(ROOT . 'helpers/' . $className . '.php')) {
      require_once(ROOT . 'helpers/' . $className . '.php');
    }
    else if (file_exists(ROOT . 'tests/' . $className . '.php')) {
      require_once(ROOT . 'tests/' . $className . '.php');
    }
  }

?>