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

$router->get('/restaurants', 'RestaurantController@index');
$router->post('/restaurants', 'RestaurantController@store');
$router->get('/restaurants/{restaurant}', 'RestaurantController@show');
$router->put('/restaurants/{restaurant}', 'RestaurantController@update');
$router->patch('/restaurants/{restaurant}', 'RestaurantController@update');
$router->delete('/restaurants/{restaurant}', 'RestaurantController@destroy');

$router->get('/messages', 'MessageController@index');
$router->post('/messages', 'MessageController@store');
$router->get('/messages/{message}', 'MessageController@show');
$router->put('/messages/{message}', 'MessageController@update');
$router->patch('/messages/{message}', 'MessageController@update');
$router->delete('/messages/{message}', 'MessageController@destroy');

$router->post('/sms/send', "SmsController@send");
