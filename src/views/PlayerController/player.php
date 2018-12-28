<!DOCTYPE html>
<html>

<?php include(dirname(__DIR__) . '/header.php') ?>

<body>

<h1>PLAYER</h1>

<?php foreach($videos as $video): ?>

    <video height="200" controls>
        <source src="../../resources/upload/<?= $video ?>" type="video/mp4">
    </video>

<?php endforeach; ?>

</body>
</html