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
}