<?php

require_once 'User.php';
require_once __DIR__.'/../Database.php';
require_once 'SlidersList.php';

class SliderMapper
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
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
            $stmt = $this->database->connect()->prepare('INSERT INTO sliders (name, height, speed, id_user) VALUES (:name, :height, :speed, :id_user);');
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':height', $height, PDO::PARAM_STR);
            $stmt->bindParam(':speed', $speed, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);
            $stmt->execute();

            $slider = $stmt->fetch(PDO::FETCH_ASSOC);
            return 'Slider added!';
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}