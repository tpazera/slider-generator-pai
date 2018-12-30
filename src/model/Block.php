<?php

class Block
{
    private $id;
    private $width;
    private $height;
    private $color;
    private $zindex;
    private $x;
    private $y;
    private $id_slide;

    /**
     * Block constructor.
     * @param $id
     * @param $width
     * @param $height
     * @param $color
     * @param $zindex
     * @param $x
     * @param $y
     * @param $id_slide
     */
    public function __construct($id, $width, $height, $color, $zindex, $x, $y, $id_slide)
    {
        $this->id = $id;
        $this->width = $width;
        $this->height = $height;
        $this->color = $color;
        $this->zindex = $zindex;
        $this->x = $x;
        $this->y = $y;
        $this->id_slide = $id_slide;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param mixed $width
     */
    public function setWidth($width): void
    {
        $this->width = $width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param mixed $height
     */
    public function setHeight($height): void
    {
        $this->height = $height;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getZindex()
    {
        return $this->zindex;
    }

    /**
     * @param mixed $zindex
     */
    public function setZindex($zindex): void
    {
        $this->zindex = $zindex;
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * @param mixed $x
     */
    public function setX($x): void
    {
        $this->x = $x;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * @param mixed $y
     */
    public function setY($y): void
    {
        $this->y = $y;
    }

    /**
     * @return mixed
     */
    public function getIdSlide()
    {
        return $this->id_slide;
    }

    /**
     * @param mixed $id_slide
     */
    public function setIdSlide($id_slide): void
    {
        $this->id_slide = $id_slide;
    }


}