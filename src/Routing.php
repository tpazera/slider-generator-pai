<?php

require_once('controllers/DefaultController.php');
require_once('controllers/SlidersController.php');
require_once('controllers/UploadController.php');
require_once('controllers/CodeController.php');
require_once('controllers/EditorController.php');
require_once('controllers/AdminController.php');

class Routing
{
    public $routes = [];

    public function __construct()
    {
        $this->routes = [
            'index' => [
                'controller' => 'DefaultController',
                'action' => 'index'
            ],
            'login' => [
                'controller' => 'DefaultController',
                'action' => 'login'
            ],
            'logout' => [
                'controller' => 'DefaultController',
                'action' => 'logout'
            ],
            'register' => [
                'controller' => 'DefaultController',
                'action' => 'register'
            ],
            'sliders' => [
                'controller' => 'SlidersController',
                'action' => 'sliders'
            ],
            'addslider' => [
                'controller' => 'SlidersController',
                'action' => 'addslider'
            ],
            'editslider' => [
                'controller' => 'SlidersController',
                'action' => 'editslider'
            ],
            'removeslider' => [
                'controller' => 'SlidersController',
                'action' => 'removeslider'
            ],
            'updateslider' => [
                'controller' => 'EditorController',
                'action' => 'updateSlider'
            ],
            'updateslide' => [
                'controller' => 'EditorController',
                'action' => 'updateSlider'
            ],
            'addblock' => [
                'controller' => 'EditorController',
                'action' => 'addBlock'
            ],
            'addtext' => [
                'controller' => 'EditorController',
                'action' => 'addText'
            ],
            'updatetext' => [
                'controller' => 'EditorController',
                'action' => 'updateText'
            ],
            'updatetextpos' => [
                'controller' => 'EditorController',
                'action' => 'updateTextPos'
            ],
            'deletetext' => [
                'controller' => 'EditorController',
                'action' => 'deleteText'
            ],
            'updateblock' => [
                'controller' => 'EditorController',
                'action' => 'updateBlock'
            ],
            'updateblockpos' => [
                'controller' => 'EditorController',
                'action' => 'updateBlockPos'
            ],
            'deleteblock' => [
                'controller' => 'EditorController',
                'action' => 'deleteBlock'
            ],
            'addslide' => [
                'controller' => 'SlidersController',
                'action' => 'addSlide'
            ],
            'codeslider' => [
                'controller' => 'SlidersController',
                'action' => 'code'
            ],
            'admin' => [
                'controller' => 'AdminController',
                'action' => 'admin'
            ],
            'changerole' => [
                'controller' => 'AdminController',
                'action' => 'changeRole'
            ]
        ];
    }

    public function run()
    {
        $page = isset($_GET['page'])
            && isset($this->routes[$_GET['page']]) ? $_GET['page'] : 'index';

        if ($this->routes[$page]) {
            $class = $this->routes[$page]['controller'];
            $action = $this->routes[$page]['action'];

            $object = new $class;
            $object->$action();
        }
    }

}