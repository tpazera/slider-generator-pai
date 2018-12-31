<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 28.12.18
 * Time: 01:28
 */

require_once 'Text.php';
require_once 'TextMapper.php';

class TextsList implements ItemsList
{

    private $texts = array();

    public function __construct(array $textsList)
    {
        foreach ($textsList as $text) {
            array_push($this->texts, new Text($text['id_text'], $text['text'], $text['z_index'], $text['x'], $text['y'], $text['id_slide']));
        }
    }

    public function getList(): array
    {
        return $this->texts;
    }

    public function addItem(string $text, float $pos, int $zindex, int $id_slide): void
    {
        $mapper = new TextMapper();
        $id_text = $mapper->addText($text, $pos, $zindex, $id_slide);
        if($id_text) {
            array_push($this->texts, new Text($id_text, $text, $zindex, $pos, $pos, $id_slide));
        }
        $arr = array();
        array_push($arr, $id_text);
        echo json_encode($arr);
    }

}