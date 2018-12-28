<?php

class User
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

}