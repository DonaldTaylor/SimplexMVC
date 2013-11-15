<?php

  abstract class Controller {
    
    abstract public function index();
    
    public function render($title = null, $variables = null, $id = null, $viewName = null) {
      $controller = str_replace('Controller', '', get_called_class());
      $caller = $this->getCaller() !== 'index' ? $this->getCaller() : '';
      // open view
      $viewName = $viewName ?: strtolower($controller) . ($caller ? '-' . $caller : '');
      $title = $title ?: ucfirst(preg_replace('/[A-Z]/', ' $0', $controller)); // add space between words
      $class = lcfirst($controller) . ($caller ? ' ' . $caller : '');
      $this->openView($variables, $title, $class, $id, $viewName);
    }
    
    public function renderJson($array, $errorMessage = null) {
      // ensure an ajax call
      if (is_array($array) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        echo json_encode($array);
      }
    }
    
    private function openView($variables, $title, $class, $id, $viewName) {
      if (is_array($variables)) {
        extract($variables);
      }
      require_once(ROOT . 'views/' . $viewName . '.php');
    }
    
    private function getCaller() {
      $callers = debug_backtrace();
      return $callers[2]['function'];
    }
    
  }

?>