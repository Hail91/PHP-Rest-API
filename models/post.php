<?php
class Post
{
  private $conn;
  private $table = 'posts';

  // Post Properties
  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $body;
  public $author;
  public $created_at;

  // Constructor 
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get Posts
  public function get_posts()
  {
    // Create query
    $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();
    // Return Statement
    return $stmt;
  }
  // Function to retrieve single Post
  public function get_single_post()
  {
    // Create query
    $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                WHERE
                                  p.id = ?
                                LIMIT 0,1';
    // Prepare statement
    $stmt = $this->conn->prepare($query);
    // Bind post id
    $stmt->bindParam(1, $this->id);
    // Execute query
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Set properties
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];
  }
  // Function to add a post to the database
  public function add_post()
  {
    $query = 'INSERT INTO ' . $this->table . ' 
    SET
      title = :title,
      body = :body,
      author = :author,
      category_id = :category_id';
    // Prepare the statement
    $stmt = $this->conn->prepare($query);
    // Probably should 'clean' the data since it's coming from the user.
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));

    // Need to Bind data
    $stmt->bindParam('title', $this->title);
    $stmt->bindParam('body', $this->body);
    $stmt->bindParam('author', $this->author);
    $stmt->bindParam('category_id', $this->category_id);

    // Execute the query
    if ($stmt->execute()) {
      return true;
    }

    // If there is an error
    printf("Error: %s.\n", $stmt->error);
    return false;
  }
  // Update post function
  public function update_post()
  {
    $query = 'UPDATE ' . $this->table . ' 
    SET
      title = :title,
      body = :body,
      author = :author,
      category_id = :category_id
    WHERE
      id = :id';
    // Prepare the statement
    $stmt = $this->conn->prepare($query);
    // Probably should 'clean' the data since it's coming from the user.
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->body = htmlspecialchars(strip_tags($this->body));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->category_id = htmlspecialchars(strip_tags($this->category_id));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Need to Bind data
    $stmt->bindParam('title', $this->title);
    $stmt->bindParam('body', $this->body);
    $stmt->bindParam('author', $this->author);
    $stmt->bindParam('category_id', $this->category_id);
    $stmt->bindParam(':id', $this->id);

    // Execute the query
    if ($stmt->execute()) {
      return true;
    }

    // If there is an error
    printf("Error: %s.\n", $stmt->error);
    return false;
  }
  // Need to add delete post function
  public function delete_post()
  {
    // Create Query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    // Prepare Query for execution
    $stmt = $this->conn->prepare($query);
    // Clean the data
    $this->id = htmlspecialchars(strip_tags($this->id));
    // Bind the id
    $stmt->bindParam(':id', $this->id);
    // Execute the query
    if ($stmt->execute()) {
      return true;
    }

    // If there is an error
    printf("Error: %s.\n", $stmt->error);
    return false;
  }
}
