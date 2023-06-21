<?php

namespace Model;

class Database {

    protected $db_name = DB_NAME;
    protected $db_host = DB_HOST;
    protected $db_user = DB_USER;
    protected $db_pass = DB_PASS;

    public function __construct()
    {
        $this->CreatePostsTable();
        $this->CreateCategoriesTable();
        $this->CreateCategoryPostsTable();
    }
    
    /**
     * Connect database
     *
     */
    public function ConnectDB()
    {

        // Create connection
        $conn = new \mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            return $conn;
        }
    }

    /**
     * Create Posts table
     *
     */
    public function CreatePostsTable()
    {
        $conn = $this->ConnectDB();
        $sqlSelect = 'SELECT * FROM posts';
        $resultSelect = $conn->query($sqlSelect);
        $sqlCreate = 'CREATE TABLE posts (
            entity_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content VARCHAR(2000),
            thumbnail_image VARCHAR(255),
            url_key VARCHAR(255),
            post_status SMALLINT(1) DEFAULT "1",
            create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            update_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )';

        if (!$resultSelect) {
            if ($conn->query($sqlCreate) === FALSE) {
                echo "Error creating table: " . $conn->error;
              }
        }
    }

    /**
     * Create Categories table
     *
     */
    public function CreateCategoriesTable()
    {
        $conn = $this->ConnectDB();
        $sqlSelect = 'SELECT * FROM categories';
        $resultSelect = $conn->query($sqlSelect);
        $sqlCreate = 'CREATE TABLE categories (
            entity_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content VARCHAR(2000),
            thumbnail_image VARCHAR(255),
            url_key VARCHAR(255),
            category_status SMALLINT(1) DEFAULT "1",
            create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            update_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )';
        if (!$resultSelect) {
            $conn->query($sqlCreate);
        }
    }

    /**
     * Create Category posts table
     *
     */
    public function CreateCategoryPostsTable()
    {
        $conn = $this->ConnectDB();
        $sqlSelect = 'SELECT * FROM category_posts';
        $resultSelect = $conn->query($sqlSelect);
        $sqlCreate = 'CREATE TABLE category_posts (
            entity_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            category_id INT(6) UNSIGNED,
            post_id INT(6) UNSIGNED,
            FOREIGN KEY (category_id) REFERENCES categories(entity_id) ON DELETE CASCADE,
            FOREIGN KEY (post_id) REFERENCES posts(entity_id) ON DELETE CASCADE
        )';
        if (!$resultSelect) {
            if ($conn->query($sqlCreate) === FALSE) {
                echo "Error creating table: " . $conn->error;
              }
        }
    }
}