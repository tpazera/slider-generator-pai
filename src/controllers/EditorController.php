<?php

require_once "AppController.php";

require_once __DIR__.'/../model/SliderMapper.php';


class EditorController extends AppController implements Validator
{

    const MAX_FILE_SIZE = 1024*1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];

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
        $blockMapper->updateBlockPos((int)$_POST['id_block'], $_POST['x'], $_POST['y']);
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
        $textMapper->updateTextPos((int)$_POST['id_text'], $_POST['x'], $_POST['y']);
        http_response_code(200);
    }

    public function deleteText() {
        if (!isset($_POST['id_text']) && !isset($_POST['id_slide'])) {
            http_response_code(404);
            return;
        }
        $slideMapper = new SlideMapper();
        $slide = $slideMapper->getSlideById((int)$_POST['id_slide']);
        if (!((int)$slide->getIdSlider() == (int)$_SESSION['id_slider'])) {
            http_response_code(404);
            return;
        }
        $textMapper = new TextMapper();
        $textMapper->deleteText((int)$_POST['id_text']);
        http_response_code(200);
    }

    public function deleteBlock() {
        if (!isset($_POST['id_block']) && !isset($_POST['id_slide'])) {
            http_response_code(404);
            return;
        }
        $slideMapper = new SlideMapper();
        $slide = $slideMapper->getSlideById((int)$_POST['id_slide']);
        if (!((int)$slide->getIdSlider() == (int)$_SESSION['id_slider'])) {
            http_response_code(404);
            return;
        }
        $blockMapper = new BlockMapper();
        $blockMapper->deleteBlock((int)$_POST['id_block']);
        http_response_code(200);
    }

    public function updateSlide() {
//        if ($this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file']) && isset($_POST['id']) && isset($_POST['color']) && isset($_POST['bgsize'])) {
//
//            $folder = dirname(__DIR__).'/resources/upload/'.$_POST['id'];
//            if (!move_uploaded_file($_FILES['file']['tmp_name'], $folder.$_FILES['file']['name'])) {
//                //die();
//            }
//        }

        $folder = dirname(__DIR__).'/resources/sass/';
        move_uploaded_file($_FILES['file']['tmp_name'], $folder.$_FILES['file']['name']);
        http_response_code(200);

    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            return false;
        }

        if (!isset($file['type']) || !in_array($file['type'], self::SUPPORTED_TYPES)) {
            return false;
        }

        return true;
    }

}