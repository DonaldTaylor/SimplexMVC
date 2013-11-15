<?php

  class Database {
    
    private $connection;
    
    public function Database() {
    }
    
    public function query($statement, $args = null, $callback = null) {
      Assert::string($statement, 10, 10000, 'Database query statement');
      try {
        $query = $this->getConnection()->prepare($statement);
        $query->execute($args);
        if (is_callable($callback)) {
          call_user_func($callback, $this->connection->lastInsertId());
        }
      }
      catch(Exception $e) {
        Logger::error($e->getMessage());
      }
      return $query;
    }
    
    private function getConnection() {
      if ($this->connection === null) {
        try {
          $dbConnectionString = 'mysql:host=' . Settings::get('databaseHost') . ';dbname=' . Settings::get('databaseName');
          $this->connection = new PDO($dbConnectionString, Settings::get('databaseUser'), Settings::get('databasePassword'));
          $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (Exception $e) {
          Logger::error('Database connection could not be initialized: ' . $e->getMessage());
        }
      }
      return $this->connection;
    }
    
  }

?>