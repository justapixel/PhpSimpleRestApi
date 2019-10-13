<?php
  class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $name;
    public $created_at;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = 
        'SELECT 
          id,
          name
        FROM 
          ' . $this->table . ' 
        ORDER BY
          id DESC';

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
    }

    public function create() {
      $query = 'INSERT INTO '
        . $this->table . ' 
        SET
          name = :name
        ';

      $stmt = $this->conn->prepare($query);

      $this->name = filter_var($this->name, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

      $stmt->bindParam(':name', $this->name);

      if($stmt->execute()){
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function delete() {
      $query = 'DELETE FROM '
        . $this->table . '
        WHERE
          id = :id
        ';
      
      $stmt = $this->conn->prepare($query);

      $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

      $stmt->bindParam(':id', $this->id);

      if ($stmt->execute()) {
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }
}