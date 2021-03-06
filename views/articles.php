<?php
/**
 * Created by PhpStorm
 * User: bartosz
 * Date: 05.03.2021
 * Time: 18:51
 */
require_once __DIR__ . '\..\controllers\AuthController.php';
$articlesJson = $this->e($data);
$articles = json_decode(html_entity_decode($articlesJson), true);
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
        <a class="p-2 text-dark" href="#">Add Article</a>
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

<div class="container">
    <div class="row">
        <div class="col-md-1">
            <b>Id</b>
        </div>
        <div class="col-md-1">
            <b>Status</b>
        </div>
        <div class="col-md-2">
            <b>Title</b>
        </div>
        <div class="col-md-6">
            <b>Description</b>
        </div>
        <div class="col-md-2">
            <b>Actions</b>
        </div>
    </div>
    <?php foreach ($articles as $article): ?>
        <div class="row">
            <div class="col-md-1">
                <b><?php echo $article['id']; ?></b>
            </div>
            <div class="col-md-1">
                <b><?php echo $article['status_name']; ?></b>
            </div>
            <div class="col-md-2">
                <b><?php echo $article['title']; ?></b>
            </div>
            <div class="col-md-6">
                <b><?php echo $article['description']; ?></b>
            </div>
            <div class="col-md-2">
                <a href="/aurora/editarticle/<?php echo $article['id'] ?>">Edit</a>
                <a href="/aurora/deletearticle/<?php echo $article['id'] ?>">Delete</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>


    <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <small class="d-block mb-3 text-muted">&copy; Bartosz Dereń 2021</small>
            </div>
    </footer>
</main>


</body>
</html>

