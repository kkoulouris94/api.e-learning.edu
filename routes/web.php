<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['namespace' => 'Auth', 'prefix' => 'auth'], function () use ($router) {

    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->get('/me', 'AuthController@me');
    $router->post('/logout', 'AuthController@logout');

});

$router->group(['namespace' => 'Courses', 'prefix' => 'courses'], function () use ($router) {

    $router->get('/', 'CoursesController@listAll');
    $router->get('/{id}', 'CoursesController@showOne');

    $router->post('/{id}/enroll', 'CoursesController@enroll');

});

$router->group(['namespace' => 'Enrollments', 'prefix' => 'enrollments'], function () use ($router) {

    $router->post('/{id}/complete', 'EnrollmentsController@complete');

});
