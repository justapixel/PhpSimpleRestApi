<?php
  class Post {
    private $conn;
    private $table = 'posts';

    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      $query = 'SELECT 
      c.name as category_name, 
      p.id, 
      p.category_id, 
      p.title,
      p.body,
      p.author,
      p.created_at
      FROM 
        ' . $this->table . ' p
      LEFT JOIN
        categories c ON p.category_id = c.id
      ORDER BY
        p.id DESC';

      $stmt = $this->conn->prepare($query);

      $stmt->execute();

      return $stmt;
    }

    public function read_single(){
      $query = 'SELECT 
      c.name as category_name, 
      p.id, 
      p.category_id, 
      p.title,
      p.body,
      p.author,
      p.created_at
      FROM 
        ' . $this->table . ' p
      LEFT JOIN
        categories c ON p.category_id = c.id
      WHERE
        p.id = ?
      LIMIT 0,1';

      $stmt = $this->conn->prepare($query);

      $stmt->bindParam(1, $this->id);

      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      $this->title = $row['title'];
      $this->body = $row['body'];
      $this->author = $row['author'];
      $this->category_id = $row['category_id'];
      $this->category_name = $row['category_name'];
    }

    public function create() {
      $query = 'INSERT INTO '
        . $this->table . ' 
        SET
          title = :title,
          body = :body,
          author = :author,
          category_id = :category_id
        ';

      $stmt = $this->conn->prepare($query);

      $this->title = filter_var($this->title, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $this->body = filter_var($this->body, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $this->author = filter_var($this->author, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $this->category_id = filter_var($this->category_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':body', $this->body);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':category_id', $this->category_id);

      if($stmt->execute()){
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function update() {
      $query = 'UPDATE '
        . $this->table . ' 
        SET
          title = :title,
          body = :body,
          author = :author,
          category_id = :category_id
        WHERE
          id = :id
        ';

      $stmt = $this->conn->prepare($query);

      $this->title = filter_var($this->title, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $this->body = filter_var($this->body, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $this->author = filter_var($this->author, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $this->category_id = filter_var($this->category_id, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
      $this->id = filter_var($this->id, FILTER_SANITIZE_NUMBER_INT);

      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':body', $this->body);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':category_id', $this->category_id);
      $stmt->bindParam(':id', $this->id);

      if($stmt->execute()){
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
  