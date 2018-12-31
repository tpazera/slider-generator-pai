<?php

require_once __DIR__.'/../Database.php';
require_once 'SlidersList.php';

class SliderMapper
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public static function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function getSlidersList(

    ): SlidersList
    {
        try {
            $stmt = $this->database->connect()->prepare('SELECT * FROM sliders WHERE id_user = :id;');
            $stmt->bindParam(':id', $_SESSION['id_user'], PDO::PARAM_STR);
            $stmt->execute();

            $arrSliders = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $slidersList = new SlidersList($arrSliders);

            return $slidersList;
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function getSliderById(
        int $id
    ):Slider {
        try {
            $stmt = $this->database->connect()->prepare('SELECT * FROM sliders WHERE id_slider = :id;');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $slider = $stmt->fetch(PDO::FETCH_ASSOC);
            return new Slider($slider['id_slider'], $slider['name'], $slider['height'], $slider['speed'], $slider['id_user']);
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function addSlider(
        string $name, string $height, string $speed, string $id_user
    ) {
        try {
            //ADD SLIDER
            $stmt = $this->database->connect()->prepare('INSERT INTO sliders (name, height, speed, id_user) VALUES (:name, :height, :speed, :id_user);');
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':height', $height, PDO::PARAM_STR);
            $stmt->bindParam(':speed', $speed, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
            $stmt->execute();

            //GET MAX ID SLIDER
            $stmt = $this->database->connect()->prepare('SELECT MAX(id_slider) AS max_slider FROM sliders;');
            $stmt->execute();
            $id_slider = $stmt->fetch(PDO::FETCH_ASSOC);

            //ADD SLIDE
            $stmt = $this->database->connect()->prepare('INSERT INTO slides (background_color, background_image, background_size, id_slider) VALUES ("#4377F0", "default.png", "cover", :id_slider);');
            $stmt->bindParam(':id_slider', $id_slider['max_slider'], PDO::PARAM_STR);
            $stmt->execute();

            //GET MAX ID SLIDE
            $stmt = $this->database->connect()->prepare('SELECT MAX(id_slide) AS max_slide FROM slides;');
            $stmt->execute();
            $id_slide = $stmt->fetch(PDO::FETCH_ASSOC);

            //ADD TEXTBLOCK
            $stmt = $this->database->connect()->prepare('INSERT INTO textblocks (text, z_index, x, y, id_slide) VALUES ("<p>Hello world</p>", 1, 5, 5, :id_slide);');
            $stmt->bindParam(':id_slide', $id_slide['max_slide'], PDO::PARAM_STR);
            $stmt->execute();

            //CREATE FOLDER
            $folder = dirname(__DIR__).'/resources/upload/'.$id_slider['max_slider'];
            if (!mkdir($folder, 0777, true)) {
                die('Failed to create folders...');
            }
            if (!copy(dirname(__DIR__).'/resources/images/backgrounds/doodles.png', $folder.'/default.png')) {
                die('Failed to copy default slide\'s background...');
            }
            //MOVE BASIC BACKGROUND TO FOLDER
            return true;

        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function removeSliderById(
        int $id
    ):bool {
        try {
            //REMOVE SLIDER
            $stmt = $this->database->connect()->prepare('DELETE FROM sliders WHERE id_slider = :id;');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            //DELETE FOLDER
            self::deleteDir(dirname(__DIR__).'/resources/upload/'.$id);
            return true;
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }


    public function updateSlider(
        int $id, string $name, int $height, int $speed
    ):bool {
        try {
            //UPDATE SLIDER's SETTINGS
            $stmt = $this->database->connect()->prepare('UPDATE sliders SET name = :name, height = :height, speed = :speed WHERE id_slider = :id;');
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':height', $height, PDO::PARAM_STR);
            $stmt->bindParam(':speed', $speed, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

}