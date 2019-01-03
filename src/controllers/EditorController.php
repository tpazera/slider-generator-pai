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

    public function addBlock() {
        if (!isset($_POST['color']) || !isset($_POST['pos']) || !isset($_POST['zindex']) || !isset($_POST['id_slide'])) {
            http_response_code(404);
            return;
        }
        //CHECKING IF SLIDE BELONGS TO USER's SLIDER
        $slideMapper = new SlideMapper();
        $slide = $slideMapper->getSlideById((int)$_POST['id_slide']);
        if (!((int)$slide->getIdSlider() == (int)$_SESSION['id_slider'])) {
            http_response_code(404);
            return;
        }
        $slide->getBlocks()->addItem($_POST['color'], (float)$_POST['pos'], (int)$_POST['zindex'], (int)$_POST['id_slide']);
        http_response_code(200);
    }


    public function addText() {
        if (!isset($_POST['pos']) || !isset($_POST['zindex']) || !isset($_POST['id_slide'])) {
            http_response_code(404);
            return;
        }
        $slideMapper = new SlideMapper();
        $slide = $slideMapper->getSlideById((int)$_POST['id_slide']);
        if (!((int)$slide->getIdSlider() == (int)$_SESSION['id_slider'])) {
            http_response_code(404);
            return;
        }
        $slide->getTexts()->addItem("hello world", (float)$_POST['pos'], (int)$_POST['zindex'], (int)$_POST['id_slide']);
        http_response_code(200);
    }


    public function updateBlock() {
        if (!isset($_POST['id_block']) && !isset($_POST['width']) && !isset($_POST['height']) && !isset($_POST['zindex']) && !isset($_POST['color'])) {
            http_response_code(404);
            return;
        }
        $blockMapper = new BlockMapper();
        $blockMapper->updateBlock((int)$_POST['id_block'], (int)$_POST['width'], (int)$_POST['height'], (int)$_POST['zindex'], $_POST['color']);
        http_response_code(200);
    }


    public function updateBlockPos() {
        if (!isset($_POST['id_block']) && !isset($_POST['x']) && !isset($_POST['y'])) {
            http_response_code(404);
            return;
        }
        $blockMapper = new BlockMapper();
        $blockMapper->updateBlockPos((int)$_POST['id_block'], $_POST['x'], (int)$_POST['y']);
        http_response_code(200);
    }

    public function updateText() {
        if (!isset($_POST['id_text']) && !isset($_POST['text']) && !isset($_POST['zindex'])) {
            http_response_code(404);
            return;
        }
        $textMapper = new TextMapper();
        $textMapper->updateText((int)$_POST['id_text'], $_POST['text'], (int)$_POST['zindex']);
        http_response_code(200);
    }


    public function updateTextPos() {
        if (!isset($_POST['id_text']) && !isset($_POST['x']) && !isset($_POST['y'])) {
            http_response_code(404);
            return;
        }
        $textMapper = new TextMapper();
        $textMapper->updateTextPos((int)$_POST['id_text'], $_POST['x'], (int)$_POST['y']);
        http_response_code(200);
    }
}