<?php
/**
 * Created by PhpStorm.
 * User: tomek
 * Date: 28.12.18
 * Time: 01:28
 */

require_once 'Slider.php';
require_once 'ItemsList.php';

class SlidersList implements ItemsList
{

    private $sliders = array();

    public function __construct(array $slidersList)
    {
        foreach ($slidersList as $slider) {
            array_push($this->sliders, new Slider($slider['id_slider'], $slider['name'], $slider['height'], $slider['speed'], $slider['id_user']));
        }
    }

    public function getList(): array
    {
        return $this->sliders;
    }

}