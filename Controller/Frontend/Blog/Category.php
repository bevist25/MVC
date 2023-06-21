<?php

namespace Controller\Frontend\Blog;

use Core\App;

class Category extends App
{
    public function __construct()
    {
        $this->viewFile();
    }

    /**
     * Get model
     */
    public function getModel()
    {
        return $this->model('Model\Category', 'Category');
    }

    /**
     * Get model
     */
    public function getModelPost()
    {
        return $this->model('Model\Post', 'Post');
    }

    /**
     * Get category by url key
     *
     * @return array
     */
    public function getCategoryByUrlKey()
    {
        $urlProcess = $this->getUrlKey();
        $page = isset($page) ? $page - 1 : 0;
        
        //Get url key bay  Request url
        $urlkey = $urlProcess[count($urlProcess) - 1];
        $db = $this->getModel()->getCategoryByUrlKey($urlkey, $page);
        $category = [];
        if (isset($db)) {
            foreach ($db as $index => $row) {
                if ($index === 0) {
                    $category = [
                        'ID' => $row['cat_id'],
                        'title' => $row['cat_name'],
                        'content' => $row['cat_content'],
                        'thumbnail_image' => $row['cat_img'],
                        'url_key' => $row['cat_urlkey'],
                        'status' => $row['cat_status'],
                        'create_at' => $row['create_at']
                    ];
                }

                $category['posts'][] = [
                    'id' => $row['post_id'],
                    'title' => $row['post_name'],
                    'thumbnail_image' => $row['post_img'],
                    'url_key' => $row['post_urlkey']
                ];
            }
        }
        return $category;
    }
}

$category = new Category();