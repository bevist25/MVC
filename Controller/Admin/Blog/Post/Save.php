<?php

namespace Controller\Admin\Blog\Post;

use Core\App;

class Save extends App {

    public function __construct()
    {
        $this->savePost();
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
     * Undocumented function
     *
     * @return void
     */
    public function savePost()
    {
        $params = $_REQUEST;
        $title = $content = $thumbnail_image = $url_key = $categories = $id = '';
        $post_status = 0;
        if (isset($params)) {
            $title = $params['post_title'] ? $params['post_title'] : $title;
            $content = $params['content'] ? $params['content'] : $content;
            $thumbnail_image = $params['thumbnail_image_1'] ? $params['thumbnail_image_1'] : $thumbnail_image;
            $url_key = $params['url_key'] ? strtolower($params['url_key']) : $url_key;
            $post_status = $params['status'] ? $params['status'] : $post_status;
            $categories = $params['categories_id'] ? $params['categories_id'] : $categories;
            $id = $params['id'] ? (int)$params['id'] : $id;
        }
        if ($id) {
            return $this->getModel()->update($title, $content, $thumbnail_image, $url_key, $post_status, $categories, $id);
        }
        return $this->getModel()->save($title, $content, $thumbnail_image, $url_key, $post_status, $categories);
    }
}

$save = new Save();
