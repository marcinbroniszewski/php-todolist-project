<?php

//GET
$router->get('/', 'HomeController@index');
$router->get('/rejestracja', 'AuthController@register');
$router->get('/logowanie', 'AuthController@login');
$router->get('/panel', 'DashboardController@index');
$router->get('/api/get-date', 'DashboardController@getDate');
$router->get('/user/avatar', 'DashboardController@getAvatar');

//POST
$router->post('/rejestracja', 'AuthController@store');
$router->post('/logowanie', 'AuthController@authenticate');
$router->post('/api/send-date', 'DashboardController@sendDate');
$router->post('/api/add-todo', 'DashboardController@addTodo');
$router->post('/api/edit-todo', 'DashboardController@updateTodo');
$router->post('/api/delete-todo', 'DashboardController@deleteTodo');

