<?php

namespace Core;

class App {

    /**
     * get view path
     *
     * @return string
     */
    public function View()
    {
        $urlProcess = $this->getUrlKey();

        $fileName = $urlProcess[count($urlProcess) - 1];
        $viewPath = VIEW_PATH;
        if (count($urlProcess) === 1 && $urlProcess[0] === ROOT_FOLDER) {
            return FRONTEND_PATH . '/page/Index.php';
        } else {
            //remove first element and second element in urlProcess
            array_shift($urlProcess);
        }
        
        //add admin or frontend for array
        if ($urlProcess[0] == 'admin') {
            if (count($urlProcess) === 1) {
                return ADMIN_PATH . '/page/Index.php';
            }
            array_shift($urlProcess);
            array_unshift($urlProcess,'Admin');
        } else {
            array_unshift($urlProcess,'Frontend');
        }

        // check url has must be blog
        if (count($urlProcess) >= 3) {
            if ($urlProcess[count($urlProcess) - 2] === 'post' ||
                $urlProcess[count($urlProcess) - 2] === 'category')
            {
                //add blog folder for array
                array_splice($urlProcess, count($urlProcess) - 2, 0, 'blog');
                if ($urlProcess[0] !== 'Admin') {
                    array_pop($urlProcess);
                }
            } else {
                array_splice($urlProcess, 0, 0, 'page');
            }
        } else if (count($urlProcess) >= 2) {
            // check url has must be blog
            if ($urlProcess[count($urlProcess) - 1] === 'posts' ||
                $urlProcess[count($urlProcess) - 1] === 'categories')
            {
                //add blog folder for array
                array_splice($urlProcess, count($urlProcess) - 3, 0, 'blog');

            } else {
                array_splice($urlProcess, 0, 0, 'page');
            }
        }
        
        $notfoundPage = FRONTEND_PATH . '/page/404.php';
        $filePath = VIEW_PATH . '/' . implode('/',$urlProcess) . '.php';
        $viewPage = file_exists($filePath) ? $filePath : $notfoundPage;
        return $viewPage;
    }

    /**
     * require view file
     *
     */
    public function ViewFile()
    {
        $urlProcess = $this->UrlProcess();
        require_once $urlProcess[1] === 'admin' ? VIEW_PATH . '/Admin/View.php' : VIEW_PATH . '/Frontend/View.php';
    }

    /**
     * get controller
     *
     * @return string
     */
    public function Controller()
    {
        $urlProcess = $this->getUrlKey();
        
        //Controller home page
        if (count($urlProcess) === 1 && $urlProcess[0] === ROOT_FOLDER) {
            require_once CONTROLLER_PATH . '/Frontend/Index.php';
        } else {
            //remove first element and second element in urlProcess
            array_shift($urlProcess);
        }
        
        //add admin or frontend for array
        if ($urlProcess[0] == 'admin') {
            if (count($urlProcess) === 1) {
                require_once CONTROLLER_PATH . '/Admin/Index.php';
            }
            array_shift($urlProcess);
            array_unshift($urlProcess,'Admin');
        } else {
            array_unshift($urlProcess,'Frontend');
        }

        // check url has must be blog
        if (count($urlProcess) >= 3) {
            if ($urlProcess[count($urlProcess) - 2] === 'post' ||
                $urlProcess[count($urlProcess) - 2] === 'category')
            {
                //add blog folder for array
                array_splice($urlProcess, count($urlProcess) - 2, 0, 'Blog');
                if ($urlProcess[0] !== 'Admin') {
                    array_pop($urlProcess);
                }
            } else {
                //array_splice($urlProcess, 0, 0, 'Page');
            }
        } else if (count($urlProcess) >= 2) {
            // check url has must be blog
            if ($urlProcess[count($urlProcess) - 1] === 'posts' ||
                $urlProcess[count($urlProcess) - 1] === 'categories')
            {
                //add blog folder for array
                array_splice($urlProcess, count($urlProcess) - 3, 0, 'Blog');

            } else {
                //array_splice($urlProcess, 0, 0, 'Page');
            }
        }

        $path = []; 
        //convert first letter of string to uppercase
        foreach ($urlProcess as $item) {
            $path[] = ucfirst($item);
        }

        //$notfoundPage = SITE_URL . 'page/404.php';
        $filePath = CONTROLLER_PATH . '/' . implode('/',$path) . '.php';

        $apifile =  'Api/' . $fileName . 'Interface.php';
        if ($path[count($path) - 1] === 'Posts') {
            $apifile =  'Api/PostInterface.php';
        } else if ($path[count($path) - 1] === 'Categories') {
            $apifile =  'Api/CategoryInterface.php';
        }
        if (file_exists($apifile)) {
            require_once $apifile;
        }

        if (file_exists($filePath)) {
            require_once $filePath;
        }
    }

    /**
     * get controller class
     *
     * @return string
     */
    public function ControllerClass()
    {
        $filePathProcess = explode('/', $this->Controller());
        $file = $filePathProcess[count($filePathProcess) - 1];
        return str_replace('.php', '',  $file);
    }
    
    /**
     * get model
     *
     * @param string $model
     * @return Class
     */
    public function Model(string $namespace, string $model)
    {
        $api = 'Api/' . $model . 'Interface.php';
        if (file_exists($api)) {
            require_once $api;
        }
        require_once MODEL_PATH. '/' . $model . '.php';
        return new $namespace;
    }

    /**
     * Url Process
     *
     * @return array
     */
    function UrlProcess() {
        if(isset($_SERVER['REQUEST_URI']) ){
            $urlProcess = explode("/", filter_var(trim($_SERVER['REQUEST_URI'], "/")));
            //remove folder path pt2
            array_shift($urlProcess);
            return $urlProcess;
        }
    }

    /**
     * Get url key has param
     *
     * @return string
     */
    public function getUrlKey()
    {
        $urlProcess = $this->UrlProcess();

        //process url have param
        if (strpos($urlProcess[count($urlProcess) - 1], '?')) {
            $lastElement = $urlProcess[count($urlProcess) - 1];
            $fileName = explode('?' , $lastElement);
            array_pop($urlProcess);
            array_push($urlProcess, $fileName[0]);
        }
        return $urlProcess;
    }
}
