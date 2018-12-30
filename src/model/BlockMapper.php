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

}