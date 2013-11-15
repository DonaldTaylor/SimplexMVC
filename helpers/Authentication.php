<?php

  class Authentication {
    
    public function Authentication() {
      session_start();
    }
    
    public function logIn() {
      $_SESSION['authenticated'] = true;
      $_SESSION['sessionExpiresTime'] = time() + 1800; // allow 30-minute log-in
      Logger::info('User logged in to administrative area');
    }
    
    public function logOut() {
      $_SESSION['authenticated'] = false;
      session_destroy();
      Logger::info('User logged out of administrative area');
    }
    
    public function isLoggedIn() {
      return $_SESSION['authenticated'] === true && time() < $_SESSION['sessionExpiresTime'];
    }
    
  }

?>