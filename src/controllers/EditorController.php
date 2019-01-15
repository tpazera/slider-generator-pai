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
        //CHECK NUMBER OF BLOCKS
        $texts = $slide->getTexts();
        $blocks = $slide->getBlocks();
        if(sizeof($texts->getList()) + sizeof($blocks->getList()) >= 10) {
            http_response_code(404);
            $arr = array();
            array_push($arr, "cheater");
            echo json_encode($arr);
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
        $texts = $slide->getTexts();
        $blocks = $slide->getBlocks();
        if(sizeof($texts->getList()) + sizeof($blocks->getList()) >= 10) {
            http_response_code(404);
            $arr = array();
            array_push($arr, "cheater");
            echo json_encode($arr);
            return;
        }
        $slide->getTexts()->addItem("hello world", (float)$_POST['pos'], (int)$_POST['zindex'], (int)$_POST['id_slide']);
        http_response_code(200);
    }


    public function updateBlock() {
        $blockMapper = new BlockMapper();
        $userid = $blockMapper->getOwnerId($_POST['id_block']);
        if($userid != $_SESSION['id_user']) {
            echo "cheater";
            http_response_code(404);
            return;
        }
        if (!isset($_POST['id_block']) && !isset($_POST['width']) && !isset($_POST['height']) && !isset($_POST['zindex']) && !isset($_POST['color'])) {
            http_response_code(404);
            return;
        }
        $blockMapper = new BlockMapper();
        $blockMapper->updateBlock((int)$_POST['id_block'], (int)$_POST['width'], (int)$_POST['height'], (int)$_POST['zindex'], $_POST['color']);
        http_response_code(200);
    }


    public function updateBlockPos() {
        $blockMapper = new BlockMapper();
        $userid = $blockMapper->getOwnerId($_POST['id_block']);
        if($userid != $_SESSION['id_user']) {
            echo "cheater";
            http_response_code(404);
            return;
        }
        if (!isset($_POST['id_block']) && !isset($_POST['x']) && !isset($_POST['y'])) {
            http_response_code(404);
            return;
        }
        $blockMapper = new BlockMapper();
        $blockMapper->updateBlockPos((int)$_POST['id_block'], $_POST['x'], $_POST['y']);
        http_response_code(200);
    }

    public function updateText() {
        $textMapper = new TextMapper();
        $userid = $textMapper->getOwnerId($_POST['id_text']);
        if($userid != $_SESSION['id_user']) {
            echo "cheater";
            http_response_code(404);
            return;
        }
        if (!isset($_POST['id_text']) && !isset($_POST['text']) && !isset($_POST['zindex'])) {
            http_response_code(404);
            return;
        }
        $textMapper->updateText((int)$_POST['id_text'], $_POST['text'], (int)$_POST['zindex']);
        http_response_code(200);
    }


    public function updateTextPos() {
        $textMapper = new TextMapper();
        $userid = $textMapper->getOwnerId($_POST['id_text']);
        if($userid != $_SESSION['id_user']) {
            echo "cheater";
            http_response_code(404);
            return;
        }
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
        if(!empty($_POST['bgsize']) || !empty($_POST['bgcolor']) || !empty($_FILES['file']['name']) || !empty($_POST['id'])) {
            $uploadedFile = '';
            $slideMapper = new SlideMapper();
            $slide = $slideMapper->getSlideById((int)$_POST['id']);
            $idslider = $slide->getIdSlider();
            if(!empty($_FILES["file"]["type"])){
                $fileName = time().'_'.$_FILES['file']['name'];
                $valid_extensions = array("jpeg", "jpg", "png");
                $temporary = explode(".", $_FILES["file"]["name"]);
                $file_extension = end($temporary);
                if((($_FILES["hard_file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
                    $sourcePath = $_FILES['file']['tmp_name'];
                    $targetPath = $_SERVER['DOCUMENT_ROOT'].'/resources/upload/'.$idslider.'/'.$fileName;
                    if(move_uploaded_file($sourcePath,$targetPath)){
                        $uploadedFile = $fileName;
                    }
                }
            }

            echo $targetPath;
        }
    }


}