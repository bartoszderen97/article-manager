<?php
/**
 * Created by PhpStorm
 * User: bartosz
 * Date: 01.03.2021
 * Time: 14:03
 */
require_once __DIR__ . '\..\controllers\AuthController.php';
$authObj = new AuthController();
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

    <link href="views/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="views/css/login.css" rel="stylesheet">

</head>
<body>

<header class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-body border-bottom shadow-sm">
    <p class="h5 my-0 me-md-auto fw-normal">Aurora creation</p>
    <nav class="my-2 my-md-0 me-md-3">
        <a class="p-2 text-dark" href="/aurora/addarticle">Add Article</a>
        <a class="p-2 text-dark" href="/aurora/articles">Show Articles</a>
    </nav>



    <a class="btn btn-outline-primary" id="login-btn" href="/aurora/login">
        <?php if ($authObj->isUserLoggedIn()) {
            echo "Logout";
        } else {
            echo "Sign in";
        }?>

    </a>
</header>

<main id="maincontent" class="container">

    <form method="post">
        <h1 class="h3 mb-3 fw-normal">Article edit form</h1>
        <label for="inputStatus">
            Status id
        </label>
        <input type="number" name="status" id="inputStatus"
               class="form-control" placeholder="Status id" required value="<?= $this->e($status) ?>">
        <label for="inputTitle">
            Title
        </label>
        <input type="text" name="title" id="inputTitle"
               class="form-control" placeholder="Title" required value="<?= $this->e($title) ?>">
        <label for="inputDescription">
            Description
        </label>
        <textarea type="text" name="description" id="inputDescription"
               class="form-control" placeholder="Description" required>
            <?= $this->e($description) ?>
        </textarea>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Update</button>
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
