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

$router->post('/login', 'LoginController@index');
$router->post('/register', 'UsersController@register');
$router->get('/user/{id}', ['middleware' => 'auth', 'uses' =>  'UsersController@get_user']);
$router->post('/category/create', 'CategoriesController@create');
$router->post('/category/{id}/update', 'CategoriesController@update');
$router->get('/category/{id}/delete', 'CategoriesController@delete');
$router->get('/categories', 'CategoriesController@showAllCategory');
$router->get('/topics', 'TopicsController@showAllTopics');