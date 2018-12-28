<?php

require_once __DIR__.'/../Database.php';

class SlidersList
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getSlidersList(

    ):array {
        try {
            $stmt = $this->database->connect()->prepare('SELECT * FROM sliders WHERE id_user = :id;');
            $stmt->bindParam(':id', $_SESSION['id_user'], PDO::PARAM_STR);
            $stmt->execute();

            $slidersList = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $slidersList;
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}