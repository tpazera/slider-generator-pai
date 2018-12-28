<?php

require_once "AppController.php";

require_once __DIR__.'/../model/User.php';
require_once __DIR__.'/../model/UserMapper.php';
require_once __DIR__.'/../model/SliderMapper.php';


class SlidersController extends AppController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function sliders()
    {
        if(isset($_SESSION['id_user'])) {
            print_r($_SESSION);
            $this->render('sliders', ['sliders' => $this->getSliders()]);
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    private function getSliders(): array
    {
        $mapper = new SliderMapper();
        $sliders = $mapper->getSlidersList();
        return $sliders->getSliders();
    }

    private function getSliderById(int $id): Slider
    {
        $mapper = new SliderMapper();
        return $mapper->getSliderById($id);
    }


    public function addSlider() {

        $mapper = new SliderMapper();

        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                //VALIDATE SLIDER'S NAME
                if (preg_match('/[^A-Za-z]/', $_POST['name'])) {
                    return $this->render('sliders', ['message' => ['The slider\'s name should only consist of letters (' . $_POST['name'] . ' is wrong!)'], 'sliders' => $this->getSliders()]);
                } else {
                    //ADDING SLIDER!!!
                    $mapper->addSlider($_POST['name'], 500, 3000, $_SESSION['id_user']);
                    $this->render('sliders', ['message' => ['Slider added!'], 'sliders' => $this->getSliders()]);
                }
            } else {
                $this->render('sliders', ['sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function editslider() {
        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                $this->render('editslider', ['slider' => $this->getSliderById($_GET['slider'])]);
            } else {
                $this->render('sliders', ['message' => ['Slider not founded!'], 'sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

}