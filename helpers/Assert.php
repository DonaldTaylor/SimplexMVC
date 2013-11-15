<?php

  class Assert {
    
    private function Assert() {
    }
    
    public static function boolean($var, $varName = 'Argument') {
      if (is_bool($var) === false) {
        throw new Exception('"' . $varName . '" must be a boolean');
      }
    }

    public static function date($var, $varName = 'Argument') {
      if (self::string($var, 10, 10, $varName) && checkdate(date('m', $var), date('d', $var), date('Y', $var))) {
        throw new Exception('"' . $varName . '" must be a date');
      }
    }

    public static function month($var, $varName = 'Argument') {
      if (self::string($var, 7, 7, $varName) && checkdate(date('m', $var), 1, date('Y', $var))) {
        throw new Exception('"' . $varName . '" must be a date');
      }
    }

    public static function email($var, $varName = 'Argument') {
      self::string($var, 5, 127, $varName);
      if (!filter_var($var, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('"' . $varName . '" must be a valid email address');
      }
    }

    public static function func($var, $varName = 'Argument') {
      if (!is_callable($var)) {
        throw new Exception('"' . $varName . '" must be a function');
      }
    }

    public static function integer($var, $varName = 'Argument') {
      if (is_int($var) === false) {
        throw new Exception('"' . $varName . '" must be an integer');
      }
    }

    public static function positiveInteger($var, $varName = 'Argument') {
      self::integer($var, $varName);
      if ($var <= 0) {
        throw new Exception('"' . $varName . '" must be a positive integer');
      }
    }
    
    public static function string($var, $minLength = 0, $maxLength = PHP_INT_MAX, $varName = 'Argument') {
      if (is_string($var)) {
        if (strlen($var) < $minLength || strlen($var) > $maxLength) {
          throw new Exception('"' . $varName . '" must have between ' . $minLength . ' and ' . $maxLength . ' characters long');
        }
      }
      else {
        throw new Exception('"' . $varName . '" must be a string');
      }
    }

    public static function strongPassword($var, $varName = 'Argument') {
      if (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%!]).{8,16}/', $var)) {
        throw new Exception('"' . $varName . '" is not a strong enough password');
      }
    }
    
  }

?>