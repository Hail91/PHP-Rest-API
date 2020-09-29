<?php
    class Post {
        private $conn;
        private $table = 'posts';

        // Post Properties
        public $id;
        public $category_id;
        public $category_name; // This will be achieved through a table join.
        public $title;
        public $body;
        public $author;
        public $created_at;

        // Need to set a constructor that will initialize this class with a Database connection
        public function __construct($db) { // Accept a database as a parameter
            this->conn = $db; // Then set that to our connection property for this class.
        }

        // CRUD methods below
        public function get_posts() {
            $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
            FROM ' . $this->table . ' p LEFT_JOIN Categories c ON p.category_id = c.id ORDER_BY p.created_at DESC';

            // Need to create prepared statement
            $stmt = $this->conn->prepare($query)
            // Execute query
            $stmt->execute()
            // Return stmt
            return $stmt;
        }
    }