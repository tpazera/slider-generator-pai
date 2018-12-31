<?php

require_once __DIR__.'/../Database.php';
require_once 'BlocksList.php';

class BlockMapper
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function getBlocksList(
        int $id
    ): BlocksList
    {
        try {
            $stmt = $this->database->connect()->prepare('SELECT * FROM blocks WHERE id_slide = :id;');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();

            $arrBlocks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $blocksList = new BlocksList($arrBlocks);

            return $blocksList;
        }
        catch(PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function addBlock(
        string $color, float $pos, int $zindex, int $id_slide
    ) {
        try {
            //ADD BLOCK
            $stmt = $this->database->connect()->prepare('INSERT INTO blocks (width, height, color, x, y, z_index, id_slide) VALUES (100, 100, :color, :pos, :pos, :z_index, :id_slide);');
            $stmt->bindParam(':color', $color, PDO::PARAM_STR);
            $stmt->bindParam(':pos', $pos, PDO::PARAM_STR);
            $stmt->bindParam(':z_index', $zindex, PDO::PARAM_STR);
            $stmt->bindParam(':id_slide', $id_slide, PDO::PARAM_STR);
            $stmt->execute();

            //GET MAX ID BLOCK
            $stmt = $this->database->connect()->prepare('SELECT MAX(id_block) AS max_block FROM blocks;');
            $stmt->execute();
            $id_block = $stmt->fetch(PDO::FETCH_ASSOC);

            //RETURN ID OF TEXT BLOCK
            return $id_block['max_block'];

        }
        catch(PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function updateBlock(
        int $id, int $width, int $height, int $zindex
    ):bool {
        try {
            //UPDATE TEXT's SETTINGS
            $stmt = $this->database->connect()->prepare('UPDATE blocks SET width = :width, height = :height, z_index = :zindex WHERE id_block = :id;');
            $stmt->bindParam(':width', $width, PDO::PARAM_STR);
            $stmt->bindParam(':height', $height, PDO::PARAM_STR);
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

    public function updateBlockPos(
        int $id, float $x, float $y
    ):bool {
        try {
            //UPDATE TEXT's SETTINGS
            $stmt = $this->database->connect()->prepare('UPDATE blocks SET x = :x, y = :y WHERE id_block = :id;');
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

}