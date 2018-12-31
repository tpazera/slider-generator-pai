<?php

require_once 'TextMapper.php';
require_once 'BlockMapper.php';

class Slide
{
    private $id;
    private $bgcolor;
    private $bgimage;
    private $bgsize;
    private $id_slider;
    private $texts;
    private $blocks;

    public function __construct($id, $bgcolor, $bgimage, $bgsize, $id_slider)
    {
        $this->id = $id;
        $this->bgcolor = $bgcolor;
        $this->bgimage = $bgimage;
        $this->bgsize = $bgsize;
        $this->id_slider = $id_slider;
        $textMapper = new TextMapper();
        $this->texts = $textMapper->getTextsList((int)$id);
        $blockMapper = new BlockMapper();
        $this->blocks = $blockMapper->getBlocksList((int)$id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getBgcolor()
    {
        return $this->bgcolor;
    }

    public function setBgcolor($bgcolor): void
    {
        $this->bgcolor = $bgcolor;
    }

    public function getBgimage()
    {
        return $this->bgimage;
    }

    public function setBgimage($bgimage): void
    {
        $this->bgimage = $bgimage;
    }

    public function getBgsize()
    {
        return $this->bgsize;
    }

    public function setBgsize($bgsize): void
    {
        $this->bgsize = $bgsize;
    }

    public function getIdSlider()
    {
        return $this->id_slider;
    }

    public function setIdSlider($id_slider): void
    {
        $this->id_slider = $id_slider;
    }

    public function getTexts(): TextsList
    {
        return $this->texts;
    }

    public function setTexts(TextsList $texts): void
    {
        $this->texts = $texts;
    }

    public function getBlocks()
    {
        return $this->blocks;
    }

    public function setBlocks($blocks): void
    {
        $this->blocks = $blocks;
    }
}