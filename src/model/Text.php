<?php

class Text
{
    private $id;
    private $text;
    private $zindex;
    private $x;
    private $y;
    private $id_slide;

    /**
     * Text constructor.
     * @param $id
     * @param $text
     * @param $zindex
     * @param $x
     * @param $y
     * @param $id_slide
     */
    public function __construct($id, $text, $zindex, $x, $y, $id_slide)
    {
        $this->id = $id;
        $this->text = $text;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
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