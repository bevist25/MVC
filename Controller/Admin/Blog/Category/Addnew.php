<?php

namespace Controller\Admin\Blog\Category;

use Core\App;

class Addnew extends App
{
    public function __construct()
    {
        $this->ViewFile();
    }

    /**
     * Get Category model
     *
     * @return class
     */
    public function getModel()
    {
        return $this->Model('Model\Category', 'Category');
    }

}

$addnew = new Addnew();
