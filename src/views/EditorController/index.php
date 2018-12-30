<?php include(dirname(__DIR__) . '/header.php'); ?>

<h3>
    Create your responsive image slider using online generator!
</h3>
<?php if(isset($text)): ?>
    <h3 class="success"><?= $text ?></h3>
<?php endif; ?>
<?php
if(isset($_SESSION) && !empty($_SESSION)) {
    ?>
    <h3>
        You are logged in as <i><?php echo $_SESSION['email']; ?></i>
    </h3>
    <p>
        <a href="/?page=sliders" class="button">Manage your sliders!</a>
        <a href="/?page=logout" class="button">Logout!</a>
    </p>
    <?php
    //print_r($_SESSION);
} else {
    ?>
    <h3>
        To manage your sliders, <a href="/?page=login">log in</a>. If you do not have an account, <a href="/?page=login">register<a/>.
    </h3>
    <p>
        <a href="/?page=login" class="button">Log in!</a>
        <a href="/?page=register" class="button">Register now!</a>
    </p>
    <?php
}
?>


<?php include(dirname(__DIR__) . '/footer.php'); ?>