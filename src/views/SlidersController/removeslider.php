<?php include(dirname(__DIR__) . '/header.php') ?>

    <h2>Deleting your slider...</h2>

<?php if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>

<?php if(isset($removebool)): ?>
    <h3 class="success">Slider deleted!</h3>
    <h4>You will return to your slides in <span class="timer">5</span></h4>
<?php endif; ?>

<script>
    jQuery(document).ready(function() {
        var timer = 4;
        setInterval(function () {
            jQuery(".timer").html(timer);
            timer--;
        }, 1000)
        window.setTimeout('window.location="/?page=sliders";', 5000);
    });
</script>


<?php include(dirname(__DIR__) . '/footer.php') ?>