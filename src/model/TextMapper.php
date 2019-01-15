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
            $textsList = new TextsList($arrTexts);

            return $textsList;
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function addText(
        string $text, float $pos, int $zindex, int $id_slide
    ) {
        try {
            //ADD BLOCK
            $stmt = $this->database->connect()->prepare('INSERT INTO textblocks (text, z_index, x, y, id_slide) VALUES ("<p>Hello world</p>", :z_index, :pos, :pos, :id_slide);');
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);
            $stmt->bindParam(':pos', $pos, PDO::PARAM_STR);
            $stmt->bindParam(':z_index', $zindex, PDO::PARAM_STR);
            $stmt->bindParam(':id_slide', $id_slide, PDO::PARAM_STR);
            $stmt->execute();

            //GET MAX ID BLOCK
            $stmt = $this->database->connect()->prepare('SELECT MAX(id_text) AS max_text FROM textblocks;');
            $stmt->execute();
            $id_text = $stmt->fetch(PDO::FETCH_ASSOC);

            //RETURN ID OF TEXT BLOCK
            return $id_text['max_text'];

        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function updateText(
        int $id, string $text, int $zindex
    ):bool {
        try {
            //UPDATE TEXT's SETTINGS
            $stmt = $this->database->connect()->prepare('UPDATE textblocks SET text = :text, z_index = :zindex WHERE id_text = :id;');
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);
            $stmt->bindParam(':zindex', $zindex, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function updateTextPos(
        int $id, float $x, float $y
    ):bool {
        try {
            //UPDATE TEXT's SETTINGS
            $stmt = $this->database->connect()->prepare('UPDATE textblocks SET x = :x, y = :y WHERE id_text = :id;');
            $stmt->bindParam(':x', $x, PDO::PARAM_STR);
            $stmt->bindParam(':y', $y, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function deleteText(
        int $id
    ):bool {
        try {
            //UPDATE TEXT's SETTINGS
            $stmt = $this->database->connect()->prepare('DELETE FROM textblocks WHERE id_text = :id;');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function getOwnerId(
        int $id
    ):int {
        try {
            //UPDATE TEXT's SETTINGS
            $stmt = $this->database->connect()->prepare('SELECT sliders.id_user as userid FROM textblocks INNER JOIN slides ON textblocks.id_slide = slides.id_slide INNER JOIN sliders ON slides.id_slider = sliders.id_slider WHERE textblocks.id_text = :id;');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['userid'];
        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

}