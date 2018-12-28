<?php include(dirname(__DIR__) . '/header.php') ?>

    <h1>Slider Generator</h1>
    <h2>Edit your slider from this panel!</h2>
    <h3>If you want to go to the main page click <a href="/?page=index">here</a>.</h3>

<?php if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($slider)): ?>
    <?php echo $slider->getName(); ?>
<?php endif; ?>


<?php include(dirname(__DIR__) . '/footer.php') ?>