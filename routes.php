<?php

//GET
$router->get('/', 'HomeController@index');
$router->get('/rejestracja', 'AuthController@register');
$router->get('/logowanie', 'AuthController@login');
$router->get('/panel', 'DashboardController@index');
$router->get('/api/get-date','DashboardController@getDate');

//POST
$router->post('/rejestracja', 'AuthController@store');
$router->post('/logowanie', 'AuthController@authenticate');
$router->post('/api/send-date','DashboardController@sendDate');
$router->post('/api/add-todo','DashboardController@addTodo');
