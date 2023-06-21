<?php
namespace MVC\Controller\Admin;

use Core\App;

class Index extends App {
    public function __construct()
    {
        $this->ViewFile();
        require_once $this->View();
    }
}

$index = new Index();