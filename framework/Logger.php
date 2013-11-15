<?php

  class Logger {
    
    public static function getContents() {
      return file_exists(ROOT . Settings::get('logFilePath')) ? file_get_contents(ROOT . Settings::get('logFilePath')) : '';
    }
    
    public static function info($message) {
      self::addEntry('INFO ', $message);
    }
    
    public static function warn($message) {
      self::addEntry('WARN ', $message);
    }
    
    public static function error($message) {
      self::addEntry('ERROR', $message);
    }

    private static function addEntry($prefix, $message) {
      self::checkFileSize();
      $entry = date('[Y-m-d H:i:s]') . ' ' . $prefix . ' ' . $message . "\n";
      if (!file_exists(ROOT . Settings::get('logFilePath'))) {
        touch(ROOT . Settings::get('logFilePath'));
      }
      if (is_writable(ROOT . Settings::get('logFilePath'))) {
        file_put_contents(ROOT . Settings::get('logFilePath'), $entry, FILE_APPEND);
      }
    }
    
    private static function checkFileSize() {
      // delete the log file if its size is too large
      $maxFileSizeBytes = Settings::get('logFileMaxSizeMegabytes') * 1000000;
      if (file_exists(ROOT . Settings::get('logFilePath')) && filesize(ROOT . Settings::get('logFilePath')) > $maxFileSizeBytes) {
        if (unlink(ROOT . Settings::get('logFilePath'))) {
          self::info('The log file has exceed ' . $maxFileSizeBytes . ' and has been deleted');
        }
        else {
          self::error('The log file has exceed ' . $maxFileSizeBytes . ' but could not be deleted');
        }
      }
    }
    
  }

?>