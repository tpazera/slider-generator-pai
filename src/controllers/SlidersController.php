<?php

require_once "AppController.php";

require_once __DIR__.'/../model/User.php';
require_once __DIR__.'/../model/UserMapper.php';
require_once __DIR__.'/../model/SliderMapper.php';
require_once __DIR__.'/../model/SlideMapper.php';
require_once 'Validator.php';

error_reporting(0);

class SlidersController extends AppController implements Validator
{

    public function __construct()
    {
        parent::__construct();
    }

    public function sliders()
    {
        if(isset($_SESSION['id_user'])) {
            $this->render('sliders', ['sliders' => $this->getSliders()]);
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    private function getSliders(): array
    {
        $mapper = new SliderMapper();
        $sliders = $mapper->getSlidersList();
        return $sliders->getList();
    }

    private function getSliderById(int $id): Slider
    {
        $mapper = new SliderMapper();
        return $mapper->getSliderById($id);
    }

    private function removeSliderById(int $id): bool {
        $mapper = new SliderMapper();
        return $mapper->removeSliderById($id);
    }

    private function getSlides(): array
    {
        $mapper = new SlideMapper();
        $slides = $mapper->getSlidesList();
        return $slides->getList();
    }

    public function checkIfOwner(int $id): bool {
        $mapper = new SliderMapper();
        $slider = $mapper->getSliderById($id);
        if($slider->getUser() == $_SESSION['id_user'])
            return true;
        return false;
    }

    public function getNumberOfSliders(int $id) {
        $mapper = new SliderMapper();
        $number = $mapper->getNumberOfSliders($id);
        return $number;
    }

    public function addslider() {

        $mapper = new SliderMapper();

        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                //VALIDATE SLIDER'S NAME
                $number = $this->getNumberOfSliders((int) $_SESSION['id_user']);
                $maxnumber = array(0, 100, 3, 5);
                if($number >= $maxnumber[$_SESSION['role']]) {
                    $this->render('sliders', ['message' => ['You can\'t create more sliders (max: '.$maxnumber[$_SESSION['role']].')!'], 'sliders' => $this->getSliders()]);
                } else if ((preg_match('/[^A-Z a-z0-9]/', $_POST['name'])) || strlen($_POST['name']) == 0 ) {
                    $this->render('sliders', ['message' => ['The slider\'s name should only consist of letters, spaces and numbers<br>(\'' . $_POST['name'] . '\' is wrong!)'], 'sliders' => $this->getSliders()]);
                } else {
                    //ADDING SLIDER!!!
                    $addbool = $mapper->addSlider($_POST['name'], 500, 3000, $_SESSION['id_user']);
                    if($addbool)
                        $this->render('sliders', ['message' => ['Slider added!'], 'sliders' => $this->getSliders()]);
                    else
                        $this->render('sliders', ['message' => ['Error occured during adding new slider'], 'sliders' => $this->getSliders()]);
                }
            } else {
                $this->render('sliders', ['sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function editslider() {
        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                if($this->checkIfOwner($_GET['slider'])) {
                    $_SESSION["id_slider"] = $_GET['slider'];
                    $this->render('editslider', ['slider' => $this->getSliderById($_GET['slider']), 'slides' => $this->getSlides()]);
                } else {
                    $mapper = new SliderMapper();
                    $name = $mapper->getSliderById($_GET['slider'])->getName();
                    $this->render('sliders', ['message' => ['You are not the owner of slider '.$name.'!'], 'sliders' => $this->getSliders()]);
                }
            } else {
                $this->render('sliders', ['message' => ['Slider not founded!'], 'sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function addslide() {
        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                echo $_POST['id_slider'];
                if($this->checkIfOwner($_POST['id_slider'])) {
                    $_SESSION["id_slider"] = $_POST['id_slider'];
                    $mapper = new SlideMapper();
                    $slides = $mapper->getSlidesList();
                    if(sizeof($slides->getList()) >= 5) {
                        $this->render('editslider',  ['message' => ['You can add only 5 slides!'], 'slider' => $this->getSliderById($_POST['id_slider']), 'slides' => $this->getSlides()]);
                    } else {
                        $mapper->addSlide((int) $_POST['id_slider']);
                        $this->render('editslider',  ['message' => ['Slider added!'], 'slider' => $this->getSliderById($_POST['id_slider']), 'slides' => $this->getSlides()]);
                    }
                } else {
                    $mapper = new SliderMapper();
                    $name = $mapper->getSliderById($_POST['id_slider'])->getName();
                    $this->render('sliders', ['message' => ['You are not the owner of slider '.$name.'!'], 'sliders' => $this->getSliders()]);
                }
            } else {
                $this->render('sliders', ['message' => ['Slider not founded!'], 'sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function removeslider() {
        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                if($this->checkIfOwner($_GET['slider'])) {
                    $removebool = $this->removeSliderById($_GET['slider']);
                    $this->render('removeslider', ['removebool' => $removebool]);
                } else {
                    $mapper = new SliderMapper();
                    $name = $mapper->getSliderById($_GET['slider'])->getName();
                    $this->render('sliders', ['message' => ['You are not the owner of slider'.$name.'!'], 'sliders' => $this->getSliders()]);
                }
            } else {
                $this->render('sliders', ['message' => ['Slider not founded!'], 'sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function code()
    {
        if(isset($_SESSION['id_user'])) {
            if ($this->isPost()) {
                if($this->checkIfOwner($_GET['slider'])) {
                    $_SESSION["id_slider"] = $_GET['slider'];
                    $this->generateCode();
                    $archive_name = dirname(__DIR__).'/resources/upload/zips/slider'.$_SESSION["id_slider"].'.tar';
                    $dir_path = dirname(__DIR__).'/resources/upload/'.$_SESSION["id_slider"];
                    try {
                        unlink($archive_name);
                        unlink($archive_name.'.gz');
                    } catch(Exception $e) {
                        //echo $e;
                    }
                    $archive = new PharData($archive_name);
                    $archive->buildFromDirectory($dir_path);
                    $archive->compress(Phar::GZ);
                    $this->render('code', ['slider' => $this->getSliderById($_GET['slider']), 'slides' => $this->getSlides()]);
                } else {
                    $mapper = new SliderMapper();
                    $name = $mapper->getSliderById($_GET['slider'])->getName();
                    $this->render('sliders', ['message' => ['You are not the owner of slider '.$name.'!'], 'sliders' => $this->getSliders()]);
                }
            } else {
                $this->render('sliders', ['message' => ['Slider not founded or you are not an owner!'], 'sliders' => $this->getSliders()]);
            }
        } else {
            $url = "http://$_SERVER[HTTP_HOST]/";
            header("Location: {$url}?page=index");
            exit();
        }
    }

    public function generateCode() {
        $my_file = dirname(__DIR__).'/resources/upload/'.$_SESSION["id_slider"].'/index.html';
        $handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
        $header = file_get_contents( dirname(__DIR__).'/resources/slidergenerator/header.html');
        $footer = file_get_contents( dirname(__DIR__).'/resources/slidergenerator/footer.html');
        $slider = $this->getSliderById((int)$_SESSION['id_slider']);
        $slides = $this->getSlides();
        $stringData = $header;

        if(isset($slider)):
            if(isset($slides)):
                $i = 1;

                $stringData .= '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="'.$slider->getSpeed().'">';
                $stringData .= "\n\t";
                $stringData .= '<ol class="carousel-indicators">';
                $stringData .= "\n";
                $x = 0;
                foreach($slides as $slide):
                    if($x == 0) $class = 'active';
                    else $class = '';
                    $stringData .= "\t\t";
                    $stringData .= '<li data-target="#carouselExampleIndicators" data-slide-to="'.$x.'" class="'.$class.'"></li>';
                    $stringData .= "\n";
                    $x++;
                endforeach;
                $stringData .= "\t";
                $stringData .= '</ol>';
                $stringData .= "\n\t";
                $stringData .= '<div class="carousel-inner">';
                $stringData .= "\n";
                foreach($slides as $slide):
                    if($i == 1) $class = 'active';
                    else $class = '';
                    $stringData .= "\t\t";
                    $stringData .= '<div class="carousel-item '.$class.'">';
                    $stringData .= "\n";
                    if($slide->getBgimage() != '') $bgimage = "background-image: url('".$slide->getBgimage()."')";
                    else $bgimage = '';
                    $stringData .= "\t\t\t";
                    $stringData .= '<div id="bgcontainer'.$slide->getId().'" class="bgcontainer d-block w-100" style="position: relative; height: '.$slider->getHeight().'px;'.$bgimage.'; background-size: '.$slide->getBgsize().'; background-color: '.$slide->getBgcolor(). '">';
                    $stringData .= "\n";
                    $texts = $slide->getTexts();
                    foreach($texts->getList() as $text):
                        $stringData .= "\t\t\t\t";
                        $stringData .= '<div id="textcontainer'.$text->getId().'" data-el="'.$text->getId().'" class="textcontainer element" style="position: absolute; left: '.$text->getX().'%; top: '.$text->getY().'%; z-index: '.$text->getZindex().'">'.$text->getText().'</div>';
                        $stringData .= "\n";
                    endforeach;
                    $blocks = $slide->getBlocks();
                    foreach($blocks->getList() as $block):
                        $stringData .= "\t\t\t\t";
                        $stringData .= '<div id="blockcontainer'.$block->getId().'" data-el="'.$block->getId().'" class="blockcontainer element" style="position: absolute; left: '.$block->getX().'%; top: '.$block->getY().'%; z-index: '.$block->getZindex().'; width: '.$block->getWidth().'%; height: '.$block->getHeight().'%; background-color: '.$block->getColor().'"></div>';
                        $stringData .= "\n";
                    endforeach;
                    $stringData .= "\t\t\t";
                    $stringData .= '</div>';
                    $stringData .= "\n";
                    $stringData .= "\t\t";
                    $stringData .= '</div>';
                    $stringData .= "\n";
                    $i++;
                endforeach;
                $stringData .= "\t";
                $stringData .= "</div>";
                $stringData .= "\n\t";
                $stringData .= "<a class='carousel-control-prev' href='#carouselExampleIndicators' role='button' data-slide='prev'>";
                $stringData .= "<span class='carousel-control-prev-icon' aria-hidden='true'></span>";
                $stringData .= "<span class='sr-only'>Previous</span>";
                $stringData .= "\t";
                $stringData .= "</a>";
                $stringData .= "\t";
                $stringData .= "<a class='carousel-control-next' href='#carouselExampleIndicators' role='button' data-slide='next'>'";
                $stringData .= "<span class='carousel-control-next-icon' aria-hidden='true'></span>";
                $stringData .= "<span class='sr-only'>Next</span>";
                $stringData .= "</a>\n";
                $stringData .= "</div>\n";
            endif;
        endif;

        $stringData .= $footer;
        fwrite($handle, $stringData);
        fclose($handle);
    }

}