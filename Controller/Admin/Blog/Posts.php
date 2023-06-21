<?php
namespace Controller\Admin\Blog;

use Core\App;

class Posts extends App {

    public function __construct()
    {
        $this->ViewFile();
    }

    /**
     * get model
     *
     * @return class
     */
    public function getModel()
    {
        return $this->Model('Model\Post', 'Post');
    }

    /**
     * get posts
     *
     * @return array
     */
    public function getPosts()
    {
        $page = isset($_GET['page']) ? $_GET['page'] - 1 : 0;
        return $this->getModel()->getPosts($page*9);
    }
}

$posts = new Posts();
