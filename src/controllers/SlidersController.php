<?php

require_once "AppController.php";

require_once __DIR__.'/../model/User.php';
require_once __DIR__.'/../model/UserMapper.php';
require_once __DIR__.'/../model/SliderMapper.php';
require_once 'Validator.php';


class SlidersController extends AppController implements Validator
{

    public function __construct()
    {
        parent::__construct();
    }

    public function sliders()
    {
        if(isset($_SESSION['id_user'])) {
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

    private function removeSliderById(int $id): bool {
        $mapper = new SliderMapper();
        return $mapper->removeSliderById($id);
    }

    public function checkIfOwner(int $id): bool {
        $mapper = new SliderMapper();
        $slider = $mapper->getSliderById($id);
        if($slider->getUser() == $_SESSION['id_user'])
            return true;
        return false;
    }


    public function addslider() {

        $mapper = new SliderMapper();

        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                //VALIDATE SLIDER'S NAME
                if (preg_match('/[^A-Z a-z0-9]/', $_POST['name'])) {
                    $this->render('sliders', ['message' => ['The slider\'s name should only consist of letters, spaces and numbers<br>(' . $_POST['name'] . ' is wrong!)'], 'sliders' => $this->getSliders()]);
                } else {
                    //ADDING SLIDER!!!
                    $addbool = $mapper->addSlider($_POST['name'], 500, 3000, $_SESSION['id_user']);
                    if($addbool)
                        $this->render('sliders', ['message' => ['Slider added!'], 'sliders' => $this->getSliders()]);
                    else
                        $this->render('sliders', ['message' => ['Error occured during adding new slider'], 'sliders' => $this->getSliders()]);
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
                if($this->checkIfOwner($_GET['slider'])) {
                    $_SESSION["id_slider"] = $_GET['slider'];
                    $this->render('editslider', ['slider' => $this->getSliderById($_GET['slider'])]);
                } else {
                    $mapper = new SliderMapper();
                    $name = $mapper->getSliderById($_GET['slider'])->getName();
                    $this->render('sliders', ['message' => ['You are not the owner of slider'.$name.'!'], 'sliders' => $this->getSliders()]);
                }
            } else {
                $this->render('sliders', ['message' => ['Slider not founded!'], 'sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function removeslider() {
        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                if($this->checkIfOwner($_GET['slider'])) {
                    $this->render('removeslider', ['removebool' => $this->removeSliderById($_GET['slider'])]);
                } else {
                    $mapper = new SliderMapper();
                    $name = $mapper->getSliderById($_GET['slider'])->getName();
                    $this->render('sliders', ['message' => ['You are not the owner of slider'.$name.'!'], 'sliders' => $this->getSliders()]);
                }
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