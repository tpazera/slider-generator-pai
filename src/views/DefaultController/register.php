<?php include(dirname(__DIR__) . '/header.php') ?>

    <h1>Slider Generator</h1>
    <h2>Register your account!</h2>
    <h3>If you have an account, log in <a href="/?page=login">here</a>.</h3>

<?php
    if(isset($message)): ?>
    <?php foreach($message as $item): ?>
        <h3 class="error"><?= $item ?></h3>
    <?php endforeach; ?>
<?php endif; ?>


    <form class="register" action="?page=register" method="POST">
        <label for="name">Name: </label><input name="name" value="<?php if(isset($_POST['name']) && !preg_match('/[^A-Za-z]/', $_POST['name'])) echo $_POST['name'] ?>" required/><br>
        <label for="surname">Surname: </label><input name="surname" value="<?php if(isset($_POST['surname']) && !preg_match('/[^A-Za-z]/', $_POST['surname'])) echo $_POST['surname'] ?>" required/><br>
        <label for="email">E-mail: </label><input name="email" value="<?php if(isset($_POST['email']) && preg_match('/[^@]+@[^\.]+\..+/', $_POST['email'])) echo $_POST['email'] ?>" required/><br>
        <label for="password">Password: </label><input name="password" type="password" required/><br>
        <input type="submit" value="Register"/>
    </form>

<?php include(dirname(__DIR__) . '/footer.php') ?>