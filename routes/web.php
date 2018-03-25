<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('/login', 'LoginController@login');

$router->post('/register', 'UsersController@register');

$router->get('/topics', 'TopicsController@getAllTopics');

$router->get('/topic/{id}', 'TopicsController@show');
$router->get('/topic/{id}/category', 'TopicsController@topicsOfACategory');


$router->get('/categories', 'CategoriesController@showAllCategory');

$router->group(['middleware' => 'auth'], function($router) {
    $router->post('/logout', 'LoginController@logout');
    $router->post('/topic/create/new', 'TopicsController@create');
    $router->post('/category/create/new', 'CategoriesController@create');
    $router->post('/category/{id}/update', 'CategoriesController@update');
    $router->get('/category/{id}/delete', 'CategoriesController@delete');
    $router->post('/reply/create/{id}', 'RepliesController@store');
    $router->post('topic/like/{id}', 'TopicsController@like');
    $router->post('topic/unlike/{id}', 'TopicsController@unlike');
    $router->post('reply/like/{id}', 'RepliesController@like');
    $router->post('reply/unlike/{id}', 'RepliesController@unlike');
});
