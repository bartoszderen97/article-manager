<?php
/**
 * Created by PhpStorm
 * User: bartosz
 * Date: 01.03.2021
 * Time: 19:17
 */

require_once 'vendor/autoload.php';
require_once 'controllers/AuthController.php';
require_once 'config/DbConnection.php';

use Delight\Db\PdoDsn;
use League\Plates\Engine;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::group(['prefix' => '/aurora'], function () {
    SimpleRouter::get('/', function () {
        $templates = new Engine('views');
        echo $templates->render('home');
    });

    SimpleRouter::match(['get', 'post'], '/login', function () {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $authController = new AuthController();
            $response = $authController->loginUser($_POST['email'], $_POST['password']);
            if ($response === AuthController::AUTH_SUCCESS) {
                SimpleRouter::response()->redirect('/aurora');
            } else {
                var_dump($response);
            }
        } else {
            $templates = new Engine('views');
            echo $templates->render('login');
        }
    });

    SimpleRouter::match(['get', 'post'], '/register', function () {
        if (isset($_POST['email']) && isset($_POST['password'])
            && isset($_POST['username']) && isset($_POST['password_confirm'])) {
            $authController = new AuthController();
            $response = $authController->registerUser($_POST['username'], $_POST['email'], $_POST['password']);
            if ($response === AuthController::AUTH_SUCCESS) {
                SimpleRouter::response()->redirect('/aurora/login');
            } else {
                die($response);
            }
        } else {
            $templates = new Engine('views');
            echo $templates->render('register');
        }
    });

    SimpleRouter::get('/articles', function () {

        $authController = new AuthController();
        if ($authController->isUserLoggedIn()) {
            $dbConn = new DbConnection();
            $dbConn = $dbConn->getConnectionMysql();
            $query = "SELECT * FROM articles a JOIN statuses s ON a.status_id=s.id;";
            $result = mysqli_query($dbConn, $query);
            $data = [];

            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
            }

            $templates = new Engine('views');
            echo $templates->render('articles', ['data' => json_encode($data)]);

        } else {
            SimpleRouter::response()->redirect('/aurora/login');
        }

    });

    SimpleRouter::get('deletearticle/{id}', function ($deletearticleId) {

        $authController = new AuthController();
        if ($authController->isUserLoggedIn()) {
            $dbConn = new DbConnection();
            $dbConn = $dbConn->getConnectionMysql();

            $query = "DELETE FROM articles WHERE id=".$deletearticleId.";";
            mysqli_query($dbConn, $query);
            SimpleRouter::response()->redirect('/aurora/articles');
        }  else {
            SimpleRouter::response()->redirect('/aurora/login');
        }
    });


    SimpleRouter::match(['get', 'post'], 'editarticle/{id}', function ($editarticleId) {

        $authController = new AuthController();
        if ($authController->isUserLoggedIn()) {
            $dbConn = new DbConnection();
            $dbConn = $dbConn->getConnectionMysql();

            $query = "SELECT * FROM articles WHERE id=".$editarticleId.";";

            $row = mysqli_fetch_assoc(mysqli_query($dbConn, $query));

            $templates = new Engine('views');
            echo $templates->render('editarticle', [
                'title' => $row['title'],
                'description' => $row['description'],
                'status' => $row['status_id']
            ]);
        }  else {
            SimpleRouter::response()->redirect('/aurora/login');
        }
    });

    SimpleRouter::get('/not-found', function () {
        return 'Page not found';
    });
});

SimpleRouter::error(function(Request $request, \Exception $exception) {
    if($exception instanceof NotFoundHttpException && $exception->getCode() === 404) {
        SimpleRouter::response()->httpCode(404)->redirect('/aurora/not-found');
    }

});
