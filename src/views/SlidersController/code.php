<?php include(dirname(__DIR__) . '/header.php') ?>

    <h2>
        <?php if(isset($slider)): ?>
            <span data-slider="<?= $slider->getId(); ?>" id="sliderHeader">PREVIEW: <?php echo $slider->getName(); ?></span> #<?php echo $slider->getId(); ?>
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
    <?php if(isset($slides)): ?>
        <?php $i = 1 ?>
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="<?= $slider->getSpeed() ?>">
            <ol class="carousel-indicators">
                <?php $x = 0 ?>
                <?php foreach($slides as $slide): ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $x ?>" class="<?php if($x == 0) echo 'active'; ?>"></li>
                <?php $x++ ?>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner">
            <?php foreach($slides as $slide): ?>

                <div class="carousel-item <?php if($i == 1) echo 'active' ?>">
                    <div id="bgcontainer<?= $slide->getId(); ?>" class="bgcontainer d-block w-100" style="position: relative; height: <?php echo $slider->getHeight(); ?>px; <?php if($slide->getBgimage() != '') { ?>background-image: url('../../resources/upload/<?= $slider->getId(); ?>/<?= $slide->getBgimage(); ?>'); <?php } ?> background-size: <?= $slide->getBgsize(); ?>; background-color: <?= $slide->getBgcolor(); ?>">
                        <?php $texts = $slide->getTexts(); ?>
                        <?php foreach($texts->getList() as $text): ?>
                            <div id="textcontainer<?= $text->getId(); ?>" data-el="<?= $text->getId(); ?>" class="textcontainer element" style="position: absolute; left: <?= $text->getX(); ?>%; top: <?= $text->getY(); ?>%; z-index: <?= $text->getZindex(); ?>"><?= $text->getText(); ?></div>
                        <?php endforeach; ?>
                        <?php $blocks = $slide->getBlocks(); ?>
                        <?php foreach($blocks->getList() as $block): ?>
                            <div id="blockcontainer<?= $block->getId(); ?>" data-el="<?= $block->getId(); ?>" class="blockcontainer element" style="position: absolute; left: <?= $block->getX(); ?>%; top: <?= $block->getY(); ?>%; z-index: <?= $block->getZindex(); ?>; width: <?= $block->getWidth(); ?>%; height: <?= $block->getHeight(); ?>%; background-color: <?= $block->getColor(); ?>"></div>
                        <?php endforeach; ?>
                    </div>
                </div>

            <?php
            $i++;
            endforeach;
            ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    <?php endif ?>

    <a href="../../resources/upload/zips/slider<?= $slider->getId() ?>.tar.gz"><button class="btn btn-download" style="width:100%"><i class="fa fa-download"></i> Download</button></a>

<?php endif; ?>

<?php
function cmp($a, $b)
{
    return strcmp($a->getZindex(), $b->getZindex());
}
?>

<?php include(dirname(__DIR__) . '/footer.php') ?>