<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 28.12.18
 * Time: 01:28
 */

require_once 'Text.php';

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

}