<?php

  class Settings {
    
    private function Settings() {
    }
    
    public static function get($setting) {
      // get user-defined settings
      require_once(ROOT . 'settings.php');
      global $settings;
      // return requested settings param
      return $settings ? $settings[$setting] : null;
    }
    
  }

?>