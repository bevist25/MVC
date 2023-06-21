<?php
namespace Controller\Admin\Blog\Post;

use Core\App;

class Addnew extends App
{
    public function __construct()
    {
        $this->ViewFile();
    }

    public function getModel()
    {
        return $this->Model('Model\Post', 'Post');
    }

    public function getModelCategory()
    {
        return $this->Model('Model\Category', 'Category');
    }
}

$addnew = new Addnew();
