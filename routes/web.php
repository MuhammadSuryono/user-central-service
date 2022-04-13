<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return response()->json([
        "status" => "success",
        "message" => "Welcome to the API",
        "app_version" => "1.0.0",
        "app_name" => env('APP_NAME', 'User Central Service'),
    ]);
});

$router->group(['prefix' => 'api/v1'], function () use ($router)
{
    // Auth
    $router->group(['prefix' => 'auth'], function () use ($router)
    {
        $router->post('login', 'AuthController@login');
        $router->post('check', 'AuthController@check');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh-token', 'AuthController@refresh_token');
    });

    $router->group(['prefix' => 'user'], function () use ($router)
    {
        $router->get('/', 'UserController@list_all');
        $router->get('/{id}', 'UserController@show');
        $router->post('/', 'UserController@create_user');
        $router->put('/{id}', 'UserController@update_user');
        $router->delete('/{id}', 'UserController@destroy');
        $router->post('/document', 'UserController@upload_document');
    });

    $router->group(['prefix' => 'division'], function () use ($router)
    {
        $router->get('/', 'DivisionController@list_all');
        $router->get('/{id}', 'DivisionController@show');
        $router->post('/', 'DivisionController@create_division');
        $router->put('/{id}', 'DivisionController@update_division');
        $router->delete('/{id}', 'DivisionController@delete_division');
    });

    $router->group(['prefix' => 'position'], function () use ($router)
    {
        $router->get('/', 'PositionController@list_all');
        $router->get('/{id}', 'PositionController@show');
        $router->post('/', 'PositionController@create_position');
        $router->put('/{id}', 'PositionController@update_position');
        $router->delete('/{id}', 'PositionController@delete_position');
    });

    $router->group(['prefix' => 'level'], function () use ($router)
    {
        $router->get('/', 'LevelController@list_all');
        $router->get('/{id}', 'LevelController@show');
        $router->post('/', 'LevelController@create_level');
        $router->put('/{id}', 'LevelController@update_level');
        $router->delete('/{id}', 'LevelController@delete_level');
    });


});
