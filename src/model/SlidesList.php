<?php

require_once 'Slide.php';
require_once 'ItemsList.php';

class SlidesList implements ItemsList
{

    private $slides = array();

    public function __construct(array $slidesList)
    {
        foreach ($slidesList as $slide) {
            array_push($this->slides, new Slide($slide['id_slide'], $slide['background_color'], $slide['background_image'], $slide['background_size'], $slide['id_slider']));
        }
    }

    public function getList(): array
    {
        return $this->slides;
    }

}