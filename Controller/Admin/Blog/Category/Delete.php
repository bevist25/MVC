<?php

namespace Controller\Admin\Blog\Category;

use Core\App;

class Delete extends App {

    public function __construct()
    {
        $this->delete();
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
    public function delete()
    {
        $params = $_REQUEST;
        return $this->getModel()->delete($params['id']);
    }
}

$save = new Delete();