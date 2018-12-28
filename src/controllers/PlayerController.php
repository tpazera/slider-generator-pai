<?php

class PlayerController extends AppController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function player()
    {
        $this->render('player', [ 'videos' => $this->getVideos()]);
    }

    private function getNotHidden(array $files) {
        foreach($files as $key=>$file) {
            if ($file[0] === '.') {
                unset($files[$key]);
            };

        }
        return $files;
    }
    private function getVideos(): array
    {
        $files = scandir(dirname(__DIR__) . self::UPLOAD_DIRECTORY, SCANDIR_SORT_NONE);

        return $this->getNotHidden($files);
    }

}