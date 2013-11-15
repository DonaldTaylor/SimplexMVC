<?php

  abstract class Model {
    
    protected $values;
    private $db;
    
    public function Model() {
      $this->values = array('id' => null);
      $this->db = new Database;
    }
    
    public function __toString() {
      return print_r($this->values);
    }

    public function asArray() {
      return $this->values;
    }
    
    public function getId() {
      return $this->values['id'];
    }
    
    public function setId($id) {
      $this->values['id'] = $id;
    }
    
    public static function all() {
      $db = new Database;
      $query = $db->query('SELECT * FROM ' . self::getTableName());
      return static::resolveQuery($query);
    }
    
    public function equals($model) {
      return $model === null ? false : $this->values === $model->values;
    }
    
    public function save() {
      $keys = implode(',', array_keys($this->values));
      $argPlaceholders = implode(',', array_map(function($key) { return ':' . $key; }, array_keys($this->values)));
      $statement = 'REPLACE INTO ' . self::getTableName() . ' (' . $keys . ') VALUES (' . $argPlaceholders . ')';
      $t = $this;
      $this->db->query($statement, $this->values, function($lastInsertId) use ($t) {
        $t->setId((int) $lastInsertId);
      });
      return $this;
    }
    
    public function destroy() {
      $this->db->query('DELETE FROM ' . self::getTableName() . ' WHERE id = :id', array('id' => $this->values['id']));
      return $this;
    }
    
    public static function delete($id) {
      if (isset($id)) {
        $db = new Database;
        $db->query('DELETE FROM ' . self::getTableName() . ' WHERE id = :id', array('id' => $id));
      }
    }
  
    public static function filter($callback) {
      Assert::func($callback);
      return array_filter(self::all(), $callback);
    }
    
    public static function find($id) {
      if (isset($id)) {
        $db = new Database;
        $query = $db->query('SELECT * FROM ' . self::getTableName() . ' WHERE id = :id', array('id' => $id));
        $returnValue = static::resolveQuery($query);
        return count($returnValue) === 1 ? $returnValue[0] : null;
      }
      else {
        return null;
      }
    }
    
    abstract public static function resolveQuery($query);
    
    protected static function getTableName() {
      // table name is the plural class name
      return get_called_class() . 's';
    }
    
  }

?>