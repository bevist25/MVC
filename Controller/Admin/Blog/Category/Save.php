<?php

namespace Controller\Admin\Blog\Category;

use Core\App;

class Save extends App {

    public function __construct()
    {
        $this->saveCategory();
    }

    /**
     * get model
     *
     * @return class
     */
    public function getModel()
    {
        return $this->Model('Model\Category', 'Category');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function saveCategory()
    {
        $params = $_REQUEST;
        $title = $content = $thumbnail_image = $url_key = '';
        $category_status = 0;
        if (isset($params)) {
            $title = $params['category_title'] ? $params['category_title'] : $title;
            $content = $params['content'] ? $params['content'] : $content;
            $thumbnail_image = $params['thumbnail_image_1'] ? $params['thumbnail_image_1'] : $thumbnail_image;
            $url_key = $params['url_key'] ? strtolower($params['url_key']) : $url_key;
            $category_status = $params['status'] ? $params['status'] : $category_status;
            $id = $params['id'] ? (int)$params['id'] : $id;
        }
        if ($id) {
            return $this->getModel()->update($title, $content, $thumbnail_image, $url_key, $category_status, $id);
        }
        return $this->getModel()->save($title, $content, $thumbnail_image, $url_key, $category_status);
    }
}

$save = new Save();