<?php

namespace Model;

use Api\CategoryInterface;
use Model\Database;

class Category implements CategoryInterface {

    /**
     * Database
     *
     * @var Database
     */
    protected $database;

    /**
     * @param Database $database
     */
    public function __construct()
    {
        $this->database = new Database();
    }

    /**
     * get category list
     *
     * @return array
     */
    public function getCategories()
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = 'SELECT * FROM categories';
        $result = $conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Get category by id
     *
     * @param int $id
     * @return array
     */
    public function getCategoryById($id)
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM categories WHERE entity_id=$id";
        $result = $conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * get post list
     *
     * @param $categoryId
     * @return array
     */
    public function getCategoiesByPostId($postId)
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM categories
                LEFT JOIN category_posts ON categories.entity_id = category_posts.entity_id
                WHERE post_id = $postId";
        $result = $conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * Get category by url key
     *
     * @param string $urlkey
     * @return array
     */
    function getCategoryByUrlKey($urlkey, $paginationNumber = 0)
    {
        $conn = $this->database->ConnectDB();

        if ($paginationNumber > 1) {
            $paginationNumber = ($paginationNumber - 1) * 9;
        }
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT categories.entity_id as cat_id, categories.title as cat_name, categories.thumbnail_image as cat_img, categories.url_key as cat_urlkey, categories.category_status as cat_status,
                categories.create_at, posts.entity_id as post_id, posts.title as post_name, posts.thumbnail_image as post_img, posts.url_key as post_urlkey
                FROM categories
                LEFT JOIN category_posts ON categories.entity_id = category_posts.category_id
                LEFT JOIN posts ON category_posts.post_id = posts.entity_id
                WHERE categories.url_key = '$urlkey' ORDER BY category_posts.post_id DESC LIMIT 9 OFFSET $paginationNumber";
        $result = $conn->query($sql);
        $rows = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $rows[] = $row;
            }
        }

        return $rows;
    }
    /**
     * Save categories data
     *
     * @param string $title
     * @param string $content
     * @param string $thumbnail_image
     * @param string $url_key
     * @param int $category_status
     * @return boolean
     */
    public function save($title, $content, $thumbnail_image, $url_key, $category_status)
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO categories (title, content, thumbnail_image, url_key, category_status)
                VALUES ('$title', '$content', '$thumbnail_image', '$url_key', $category_status)";
        
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    /**
     * Update data category
     *
     * @param string $title
     * @param string $content
     * @param string $thumbnail_image
     * @param string $url_key
     * @param int $category_status
     * @param string $categories
     * @param int $id
     * @return void
     */
    public function update($title, $content, $thumbnail_image, $url_key, $category_status, $id)
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "UPDATE categories SET title='$title', content='$content', thumbnail_image='$thumbnail_image', url_key='$url_key', category_status=$category_status WHERE entity_id=$id";
        if ($conn->query($sql) === FALSE) {
            echo "Error updating record: " . $conn->error;
        }
    }

    /**
     * delete category
     *
     * @param [type] $id
     * @return string
     */
    public function delete($id)
    {
        // Create connection
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // sql to delete a record
        $sql = "DELETE FROM categories WHERE entity_id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

    /**
     * get ID
     *
     * @param array $arr
     * @return int
     */
    public function getID($arr)
    {
        return $arr['entity_id'];
    }
    
    /**
     * get title
     *
     * @param array $arr
     * @return string
     */
    public function getTitle($arr)
    {
        return $arr['title'];
    }

    /**
     * get content
     *
     * @param array $arr
     * @return string
     */
    public function getContent($arr)
    {
        return $arr['content'];
    }

    /**
     * get thumbnail image
     *
     * @param array $arr
     * @return string
     */
    public function getThumbnailImage($arr)
    {
        return $arr['thumbnail_image'];
    }

    /**
     * get url key
     *
     * @param array $arr
     * @return string
     */
    public function getUrlKey($arr)
    {
        return $arr['url_key'];
    }

    /**
     * get status
     *
     * @param array $arr
     * @return int
     */
    public function getStatus($arr)
    {
        return $arr['category_status'];
    }

    /**
     * get create at time
     *
     * @param array $arr
     * @return date
     */
    public function getCreateAt($arr)
    {
        return $arr['create_at'];
    }

    /**
     * get update at time
     *
     * @param array $arr
     * @return date
     */
    public function getUpdateAt($arr)
    {
        return $arr['update_at'];
    }
}
