<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 28.12.18
 * Time: 01:28
 */

require_once 'Block.php';

class BlocksList implements ItemsList
{

    private $blocks = array();

    public function __construct(array $blocksList)
    {
        foreach ($blocksList as $block) {
            array_push($this->blocks, new Block($block['id_block'], $block['width'], $block['height'], $block['color'], $block['z_index'], $block['x'], $block['y'], $block['id_slide']));
        }
    }

    public function getList(): array
    {
        return $this->blocks;
    }

}