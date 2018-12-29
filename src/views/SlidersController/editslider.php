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
        <div class="form-group col-lg-3 col-md-6 speed-container">
            <label>Save changes in database</label><br>
            <button id="saveSlider" type="submit" class="btn btn-primary form-control">Save</button>
        </div>
    </div>
<?php endif; ?>


<?php include(dirname(__DIR__) . '/footer.php') ?>