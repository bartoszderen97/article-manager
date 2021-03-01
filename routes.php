<?php
/**
 * Created by PhpStorm
 * User: bartosz
 * Date: 01.03.2021
 * Time: 19:17
 */

require_once 'vendor/autoload.php';

use League\Plates\Engine;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::group(['prefix' => '/aurora'], function () {
    SimpleRouter::get('/', function () {
        $templates = new Engine('views');
        echo $templates->render('home');
    });
    SimpleRouter::get('/login', function () {
        $templates = new Engine('views');
        echo $templates->render('login');
    });
    SimpleRouter::get('/not-found', function () {
        return 'Page not found';
    });
});

SimpleRouter::error(function(Request $request, \Exception $exception) {
    if($exception instanceof NotFoundHttpException && $exception->getCode() === 404) {
        header('Location: /aurora/not-found');
    }

});
