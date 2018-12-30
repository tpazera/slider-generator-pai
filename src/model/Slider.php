<?php

class Slider
{
    private $id;
    private $name;
    private $height;
    private $speed;
    private $user;

    public function __construct($id, $name, $height, $speed, $user)
    {
        $this->id = $id;
        $this->name = $name;
        $this->height = $height;
        $this->speed = $speed;
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height): void
    {
        $this->height = $height;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed): void
    {
        $this->speed = $speed;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): void
    {
        $this->user = $user;
    }

}