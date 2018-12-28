<!DOCTYPE html>
<html>

<?php include(dirname(__DIR__) . '/header.php') ?>

<body>

<h1>UPLOAD</h1>

<?php foreach($message as $item): ?>
<div><?= $item ?></div>
<?php endforeach; ?>

<form action="?page=upload" method="POST" ENCTYPE="multipart/form-data">
    <input type="file" name="file"/><br/>
    <input type="submit" value="send"/>
</form>

</body>
</html>