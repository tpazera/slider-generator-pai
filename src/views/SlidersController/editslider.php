<?php include(dirname(__DIR__) . '/header.php') ?>

    <h2>
        <?php if(isset($slider)): ?>
            <span id="sliderHeader"><?php echo $slider->getName(); ?></span> #<?php echo $slider->getId(); ?>
        <?php endif; ?>
    </h2>

<div class="errors">
    <?php if(isset($message)): ?>
        <?php foreach($message as $item): ?>
            <h5 class="error"><?= $item ?></h5>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if(isset($slider)): ?>
    <div class="form-row">
        <div class="form-group col-lg-3 col-md-6 name-container">
            <label for="sliderName">Name (letters and numbers)</label>
            <input class="form-control" type="text" id="sliderName" value="<?= $slider->getName() ?>" />
        </div>
        <div class="form-group col-lg-3 col-md-6 height-container">
            <label for="sliderHeight">Height (100px - 1000px)</label>
            <input class="form-control" type="number" max="1000" min="100" id="sliderHeight" value="<?= $slider->getHeight() ?>" />
        </div>
        <div class="form-group col-lg-3 col-md-6 speed-container">
            <label for="sliderSpeed">Speed (<?= $slider->getSpeed() ?> ms)</label>
            <input max="20000" min="500" step="100" value="<?= $slider->getSpeed() ?>" type="range" class="form-control-range" id="sliderSpeed">
        </div>
        <div class="form-group col-lg-3 col-md-6">
            <label>Save changes in database</label><br>
            <button id="saveSlider" type="submit" class="btn btn-primary form-control">Save</button>
        </div>
    </div>

    <?php if(isset($slides)): ?>
        <?php $i = 1 ?>
        <?php foreach($slides as $slide): ?>
            <div class="accordion" id="slidesList">
                <div class="card slide-container">
                    <div class="card-header" id="heading<?= $slide->getId() ?>">
                        <h2 class="mb-0">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse<?= $slide->getId() ?>" aria-expanded="true" aria-controls="collapse<?= $slide->getId() ?>">
                                Slide #<?= $i ?>
                            </button>
                        </h2>
                    </div>
                    <div id="collapse<?= $slide->getId() ?>" class="collapse <?php if($i == 1) echo 'show' ?>" aria-labelledby="heading<?= $slide->getId() ?>" data-parent="#slidesList">
                        <div class="card-body">
                            <div class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div id="bgcontainer<?= $slide->getId(); ?>" class="bgcontainer d-block w-100" style="height: <?php echo $slider->getHeight(); ?>px; background-image: url('../../resources/upload/<?= $slider->getId(); ?>/<?= $slide->getBgimage(); ?>'); background-size: <?= $slide->getBgsize(); ?>; background-color: <?= $slide->getBgcolor(); ?>">
                                        <?php $texts = $slide->getTexts(); ?>
                                        <?php foreach($texts->getList() as $text): ?>
                                            <div id="textcontainer<?= $text->getId(); ?> " class="textcontainer" style="position: relative; left: <?= $text->getX(); ?>; top: <?= $text->getY(); ?>; z-index: <?= $text->getZindex(); ?>"><?= $text->getText(); ?></div>
                                        <?php endforeach; ?>
                                        <?php $blocks = $slide->getBlocks(); ?>
                                        <?php foreach($blocks->getList() as $block): ?>
                                            <div id="textcontainer<?= $block->getId(); ?> " class="textcontainer" style="position: relative; left: <?= $block->getX(); ?>; top: <?= $block->getY(); ?>; z-index: <?= $block->getZindex(); ?>; width: <?= $block->getWidth(); ?>; height: <?= $block->getHeight(); ?>; background-color: <?= $block->getColor(); ?>"></div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <h4>Slider's settings</h4>
                                        <div class="form-group container row">
                                            <label for="bgcolor<?= $slide->getId(); ?>" class="col-md-6 col-12 col-form-label">Background color</label>
                                            <div class="col-md-6 col-12">
                                                <input id="bgcolor<?= $slide->getId(); ?>" type="color" class="form-control" value="<?= $slide->getBgcolor(); ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group container row">
                                            <label for="bgimage<?= $slide->getId(); ?>" class="col-md-6 col-12 col-form-label">Background image</label>
                                            <div class="col-md-6 col-12">
                                                <input id="bgcolor<?= $slide->getId(); ?>" type="file" class="" value="<?= $slide->getBgimage(); ?>" />
                                            </div>
                                        </div>
                                        <div class="form-group container row">
                                            <label for="bgsize<?= $slide->getId(); ?>" class="col-md-6 col-12 col-form-label">Background size</label>
                                            <div class="col-md-6 col-12">
                                                <div class="form-check form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="bgsize<?= $slide->getId(); ?>" value="cover" <?php if($slide->getBgsize() == "cover") echo 'checked' ?>> cover
                                                    </label>
                                                </div>
                                                <div class="form-check form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="bgsize<?= $slide->getId(); ?>" value="contain" <?php if($slide->getBgsize() == "contain") echo 'checked' ?>> contain
                                                    </label>
                                                </div>
                                                <div class="form-check form-check">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="radio" name="bgsize<?= $slide->getId(); ?>" value="auto" <?php if($slide->getBgsize() == "auto") echo 'checked' ?>> auto
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-12">
                                            <button id="saveSlide<?= $slide->getId(); ?>" onclick="saveSlideDB(<?= $slide->getId(); ?>)" type="submit" class="btn btn-primary form-control">Save slide in database</button>
                                        </div>
                                    </div>
                                    <div class="col-md-5 offset-md-1 col-12">
                                        <h4>Elements</h4>
                                        <ol id="elements<?= $slide->getId(); ?>" class="list-group">
                                            <?php
                                            $elements = array_merge($slide->getTexts()->getList(),$slide->getBlocks()->getList());
                                            usort($elements, "cmp");
                                            foreach($elements as $element): ?>
                                                <li class="element<?= $element->getId() ?> <?= get_class($element) ?> list-group-item d-flex justify-content-between align-items-center">
                                                    <?= get_class($element) ?> #<?= $element->getId() ?>
                                                    <div class="badges">
                                                        <span class="badge badge-primary badge-pill">UP</span>
                                                        <span class="badge badge-secondary badge-pill">DOWN</span>
                                                        <span class="badge badge-danger badge-pill">DELETE</span>
                                                    </div>
                                                </li>
                                            <?php endforeach; ?>
                                        </ol>
                                        <div class="form-group container col-12">
                                            <button id="addText<?= $slide->getId(); ?>" onclick="addText(<?= $slide->getId(); ?>)" type="submit" class="btn btn-info add-text">Add text</button>
                                            <button id="addText<?= $slide->getId(); ?>" onclick="addBlock(<?= $slide->getId(); ?>)" type="submit" class="btn btn-warning add-block">Add block</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $i++ ?>
        <?php endforeach; ?>
    <?php endif ?>
<?php endif; ?>

<?php
function cmp($a, $b)
{
    return strcmp($a->getZindex(), $b->getZindex());
}
?>

<?php include(dirname(__DIR__) . '/footer.php') ?>