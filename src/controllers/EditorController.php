<?php

require_once "AppController.php";

require_once __DIR__.'/../model/SliderMapper.php';


class EditorController extends AppController implements Validator
{

    public function __construct()
    {
        parent::__construct();
    }

    public function checkIfOwner(int $id): bool {
        $mapper = new SliderMapper();
        $slider = $mapper->getSliderById($id);
        if($slider->getUser() == $_SESSION['id_user'])
            return true;
        return false;
    }

    public function updateSlider() {
        if (!isset($_POST['name']) && !isset($_POST['height']) && !isset($_POST['speed'])) {
            http_response_code(404);
            return;
        }
        $sliderMapper = new SliderMapper();
        $sliderMapper->updateSlider((int)$_SESSION['id_slider'], $_POST['name'], (int)$_POST['height'], (int)$_POST['speed']);
        http_response_code(200);
    }

}