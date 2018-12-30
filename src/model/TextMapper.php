<?php

require_once __DIR__.'/../Database.php';
require_once 'TextsList.php';

class TextMapper
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getTextsList(
        int $id
    ): TextsList
    {
        try {
            $stmt = $this->database->connect()->prepare('SELECT * FROM textblocks WHERE id_slide = :id;');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $arrTexts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo sizeof($arrTexts);
            $textsList = new TextsList($arrTexts);

            return $textsList;
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

}