<!DOCTYPE html>
<html>
<head>
    <title>Slider generator - Tomasz Pazera</title>
    <meta charset="UTF-8">
    <meta name="description" content="Slider generator created By Tomasz Pazera">
    <meta name="author" content="Tomasz Pazera">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/resources/css/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="/resources/css/style.css">
</head>
<body class="<?= $bg ?>">
<div class="wrapper">
    <div class="container">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
                <a class="navbar-brand" href="#"><img src="../../resources/images/slider-icon.png" alt="Slider icon" height="50"><h2>Slider generator</h2></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <?php if(isset($_SESSION['id_user'])) { ?>
                        <div class="navbar-nav ml-auto">
                            <a class="nav-item nav-link active" href="/?page=index">Home <span class="sr-only">(current)</span></a>
                            <a class="nav-item nav-link" href="/?page=sliders">Your sliders</a>
                            <a class="nav-item nav-link" href="/?page=account">Account</a>
                            <a class="nav-item nav-link" href="/?page=logout">Logout</a>
                        </div>
                    <?php } else { ?>
                        <div class="navbar-nav ml-auto">
                            <a class="nav-item nav-link active" href="/?page=index">Home <span class="sr-only">(current)</span></a>
                            <a class="nav-item nav-link" href="/?page=login">Login</a>
                            <a class="nav-item nav-link" href="/?page=register">Register</a>
                        </div>
                    <?php } ?>
                </div>
            </nav>
            <div class="content">


