<?php

require_once __DIR__.'/../Database.php';
require_once 'SlidesList.php';

class SlideMapper
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getSlidesList(

    ): SlidesList
    {
        try {
            $stmt = $this->database->connect()->prepare('SELECT * FROM slides WHERE id_slider = :id;');
            $stmt->bindParam(':id', $_SESSION['id_slider'], PDO::PARAM_STR);
            $stmt->execute();

            $arrSlides = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $slidesList = new SlidesList($arrSlides);

            return $slidesList;
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

}