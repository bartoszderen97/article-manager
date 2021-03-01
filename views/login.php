<?php
/**
 * Created by PhpStorm
 * User: bartosz
 * Date: 01.03.2021
 * Time: 14:03
 */
require '../vendor/autoload.php';
require '../config/AuthController.php';

$authObj = new AuthController();
if ($authObj->isUserLoggedIn()) {
    $authObj->logoutUser();
    header('Location: index.php');
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Simple article manager">
    <meta name="author" content="Bartosz Dereń">
    <meta name="generator" content="Hugo 0.80.0">
    <title>Aurora creation recruitment task</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="./css/login.css" rel="stylesheet">

</head>
<body>

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-body border-bottom shadow-sm">
    <p class="h5 my-0 me-md-auto fw-normal">Aurora creation</p>
    <nav class="my-2 my-md-0 me-md-3">
        <a class="p-2 text-dark" href="#">Add Article</a>
        <a class="p-2 text-dark" href="#">Show Articles</a>
    </nav>



    <a class="btn btn-outline-primary" id="login-btn" href="login.php">
        <?php if ($authObj->isUserLoggedIn()) {
            echo "Logout";
        } else {
            echo "Sign in";
        }?>

    </a>
</header>

<main class="form-signin">
        <form>
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
            <label for="inputEmail" class="visually-hidden">Email address</label>
            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="visually-hidden">Password</label>
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
        </form>


    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <small class="d-block mb-3 text-muted">&copy; Bartosz Dereń 2021</small>
            </div>
    </footer>
</main>


</body>
</html>
