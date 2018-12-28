<?php include(dirname(__DIR__) . '/header.php') ?>

<h1>Slider Generator</h1>
<h2>Log in!</h2>
<h3>If you do not have an account, please <a href="/?page=register">register</a>.</h3>

<?php if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>


<form class="login" action="?page=login" method="POST">
    <label for="email">E-mail: </label><input name="email" required/><br>
    <label for="password">Password: </label><input name="password" type="password" required/><br>
    <input type="submit" value="Sign in"/>
</form>

<?php include(dirname(__DIR__) . '/footer.php') ?>