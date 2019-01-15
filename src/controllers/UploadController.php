<?php

require_once __DIR__.'/../model/SlideMapper.php';
require_once __DIR__.'/../model/SliderMapper.php';

if(!empty($_POST['bgsize']) || !empty($_POST['bgcolor']) || !empty($_FILES['file']['name']) || !empty($_POST['id'])) {
    $uploadedFile = '';
    $slideMapper = new SlideMapper();
    $slide = $slideMapper->getSlideById((int)$_POST['id']);
    $idslider = $slide->getIdSlider();
    $sliderMapper = new SliderMapper();
    $slider = $sliderMapper->getSliderById($idslider);
    if(!empty($_FILES["file"]["type"])){
        $fileName = date("Y-m-d").'_'.$_FILES['file']['name'];
        $valid_extensions = array("jpeg", "jpg", "png");
        $temporary = explode(".", $_FILES["file"]["name"]);
        $file_extension = end($temporary);
        if((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && in_array($file_extension, $valid_extensions)){
            $sourcePath = $_FILES['file']['tmp_name'];
            $targetPath = $_SERVER['DOCUMENT_ROOT'].'/resources/upload/'.$idslider.'/images/'.$fileName;
            if(move_uploaded_file($sourcePath,$targetPath)){
                $uploadedFile = $fileName;
                $query = $slideMapper->updateSlide($_POST['id'], $_POST['bgcolor'], $_POST['bgsize'], $uploadedFile);
                echo $fileName;
                return true;
            }
        }
    }
    $query = $slideMapper->updateSlide($_POST['id'], $_POST['bgcolor'], $_POST['bgsize'], '');
    return true;
}