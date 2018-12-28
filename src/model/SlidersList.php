<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 28.12.18
 * Time: 01:28
 */

require_once 'Slider.php';

class SlidersList
{

    private $sliders = array();

    public function __construct(array $slidersList)
    {
        foreach ($slidersList as $slider) {
            array_push($this->sliders, new Slider($slider['id_slider'], $slider['name'], $slider['height'], $slider['speed'], $slider['user']));
        }
    }

    public function getSliders(): array
    {
        return $this->sliders;
    }

}