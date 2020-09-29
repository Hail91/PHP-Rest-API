<?php
    class Database {
        // Private keyword specifies an attribute/function only accessible inside this class
        private $host = 'localhost';
        private $db_name = 'myblog';
        private $username = 'root';
        private $password = 'php_rest_password';
        private $conn;

        // Need a public connect function <-- Accessible from outside the class.
        public function connect() {
            this->conn = null;

            try {
                this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $error) {
                echo 'Connection Error: ' . $error->getMessage();
            }
        }
    }