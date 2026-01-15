<?php

class Controller {
    protected function view($view , $data = []) {
        extract($data);

        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die('la vue '. $view .'n\'existe pas');
        }
    }

    protected function redirect($url) {
        header('location :'.$url);
        exit();
    }
}