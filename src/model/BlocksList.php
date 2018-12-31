<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 28.12.18
 * Time: 01:28
 */

require_once 'Block.php';
require_once 'BlockMapper.php';

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

    public function addItem(string $color, float $pos, int $zindex, int $id_slide): void
    {
        $mapper = new BlockMapper();
        $id_block = $mapper->addBlock($color, $pos, $zindex, $id_slide);
        if($id_block) {
            array_push($this->blocks, new Block($id_block, 100, 100, $color, $zindex, $pos, $pos, $id_slide));
        }
        $arr = array();
        array_push($arr, $id_block);
        echo json_encode($arr);
    }
}