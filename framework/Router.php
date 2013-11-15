<?php

  class Router {
    
    public static function route($query) {
      $query = isset($query) ? $query : '';
      $queryParams = self::parseQuery($query);
      $routes = Settings::get('routes');
      // get controller and its function to call
      $controllerName = $routes[$queryParams['controllerRouteName']];
      $functionName = $queryParams['functionName'];
      // call the function in the controller
      if (class_exists($controllerName) && method_exists($controllerName, $functionName)) {
        $controller = new $controllerName;
        call_user_func(array($controller, $functionName));
      }
      else {
        self::route('404');
      }
    }
    
    public static function requireSsl() {
      if ($_SERVER['HTTPS'] === 'off' && $_SERVER['HTTP_HOST'] !== 'localhost') {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      }
    }
    
    public static function redirect($url) {
      Assert::string($url, 1, 50, 'Router redirect');
      header('Location: /' . $url);
    }
    
    private static function parseQuery($query) {
      $parsedQuery = array('controllerRouteName' => 'index', 'functionName' => 'index');
      $queryParams = false;
      if (strlen($query) > 0) {
        $queryParams = explode('/', $query);
      }
      $parsedQuery['controllerRouteName'] = isset($queryParams[0]) ? $queryParams[0] : ($query ?: 'index');
      $parsedQuery['functionName'] = isset($queryParams[1]) ? $queryParams[1] : 'index';
      return $parsedQuery;
    }
    
  }

?>