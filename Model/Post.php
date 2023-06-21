<?php

namespace Model;

use Api\PostInterface;
use Model\Database;

class Post implements PostInterface {

    /**
     * Database
     *
     * @var Database
     */
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
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
        return $arr['post_status'];
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

    /**
     * get post list
     *
     * @return array
     */
    public function getPosts($paginationNumber = 0)
    {
        $conn = $this->database->ConnectDB();
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM posts ORDER BY entity_id ASC LIMIT 9 OFFSET $paginationNumber";
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
     * get post by id
     *
     * @return array
     */
    public function getPostById($id)
    {
        $conn = $this->database->ConnectDB();
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT posts.entity_id as id, posts.title, posts.content, posts.thumbnail_image, posts.post_status, posts.url_key, category_posts.category_id
                FROM posts LEFT JOIN category_posts ON posts.entity_id = category_posts.post_id
                WHERE posts.entity_id = $id";
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
     * get post by url key
     *
     * @return array
     */
    public function getPostByUrlKey($urlKey)
    {
        $conn = $this->database->ConnectDB();
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM posts WHERE url_key='$urlKey'";
        $result = $conn->query($sql);
        $_row = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $_row = $row;
            }
        }
        return $_row;
    }

    /**
     * get post list
     *
     * @param $categoryId
     * @return array
     */
    public function getPostsByCategoryId($categoryId)
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM posts
                LEFT JOIN category_posts ON posts.entity_id = category_posts.entity_id
                WHERE category_id = $categoryId";
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
     * Create pagination for posts page
     *
     * @param string $url
     * @param integer $number
     * @param int $categoryId
     * @return void
     */
    public function getPagination($url, $number = 9, $categoryId = null)
    {
        //connect db
        $conn = $this->database->ConnectDB();

        // seclect db by category id
        if ($categoryId) {
            $sql = "SELECT * FROM posts
                    LEFT JOIN category_posts ON posts.entity_id = category_posts.post_id
                    WHERE category_posts.category_id = $categoryId";
        } else {
            $sql = "SELECT * FROM posts";
        }
        $result = $conn->query($sql);
        if ($result->num_rows > $number) {
            $totalPage = 0;
            if ($result->num_rows % $number === 0) {
                $totalPage = $result->num_rows / $number;
            } else {
                $totalPage = (int)($result->num_rows / $number) + 1;
            }
            echo '<ul class="pagition">';
            for ($x = 1; $x <= $totalPage; $x++) {
                if (isset($_GET['page']) && (int)$_GET['page'] === $x || !isset($_GET['page']) && $x === 1) {
                    echo '<li><span class="current page">'.$x.'</span></li>';
                } else {
                    if ($x !== 1) {
                        echo "<li><a href=$url?page=$x' class='page'>$x</a></li>";
                    } else {
                        echo "<li><a href='$url' class='page'>$x</a></li>";
                    }
                }
            }
            echo '</ul>';
        }
    }

    /**
     * Save post data
     *
     * @param string $title
     * @param string $content
     * @param string $thumbnail_image
     * @param string $url_key
     * @param int $post_status
     * @param string $categories
     * @return boolean
     */
    public function save($title, $content, $thumbnail_image, $url_key, $post_status, $categories)
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO posts (title, content, thumbnail_image, url_key, post_status)
                VALUES ('$title', '$content', '$thumbnail_image', '$url_key', $post_status)";
        
        if ($conn->query($sql) === TRUE) {
            if ($categories) {
                $this->saveCategoryPosts($categories, $conn->insert_id);
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    public function saveCategoryPosts($categories, $postId)
    {
        $conn = $this->database->ConnectDB();

        //convert string to array
        $categories = explode(',', $categories);
        $sql = '';
        foreach ($categories as $index => $category) {
            if ($index === 0) {
                $sql = "INSERT INTO category_posts (category_id, post_id)
                    VALUES ($category, $postId);";
            } else {
                $sql .= "INSERT INTO category_posts (category_id, post_id)
                    VALUES ($category, $postId);";
            }
        }

        if (!$conn->multi_query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    /**
     * Update data post
     *
     * @param string $title
     * @param string $content
     * @param string $thumbnail_image
     * @param string $url_key
     * @param int $post_status
     * @param string $categories
     * @param int $id
     * @return void
     */
    public function update($title, $content, $thumbnail_image, $url_key, $post_status, $categories, $id)
    {
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->deleteCategoryPosts($id);
        $sql = "UPDATE posts SET title='$title', content='$content', thumbnail_image='$thumbnail_image', url_key='$url_key', post_status=$post_status WHERE entity_id=$id";
        if ($conn->query($sql) === TRUE) {
            if ($categories) {
                $this->saveCategoryPosts($categories, $id);
            }
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

     /**
     * Delete post
     *
     * @param int $id
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
        $sql = "DELETE FROM posts WHERE entity_id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

    /**
     * Delete post
     *
     * @param int $id
     * @return string
     */
    public function deleteCategoryPosts($id)
    {
        // Create connection
        $conn = $this->database->ConnectDB();

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // sql to delete a record
        $sql = "DELETE FROM category_posts WHERE post_id=$id";

        if ($conn->query($sql) === FALSE) {
            echo "Error deleting record: " . $conn->error;
        }
    }
}
