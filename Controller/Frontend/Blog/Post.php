<?php

namespace Controller\Frontend\Blog;

use Core\App;

class Post extends App
{
    public function __construct()
    {
        $this->viewFile();
    }

    /**
     * Get model
     *
     * @return class
     */
    public function getModel()
    {
        return $this->model('Model\Post', 'Post');
    }

    /**
     * Get post
     *
     * @return array
     */
    public function getPost()
    {
        $urlKey = $this->getUrlKey()[count($this->getUrlKey()) - 1];
        return $this->getModel()->getPostByUrlKey($urlKey);
    }
}

$post = new Post();
