<?php include(dirname(__DIR__) . '/header.php') ?>

    <h2>Edit your slider from this panel!</h2>

<?php if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($slider)): ?>
    <?php echo $slider->getName(); ?>
<?php endif; ?>


<?php include(dirname(__DIR__) . '/footer.php') ?>