<?php

//GET
$router->get('/', 'HomeController@index');
$router->get('/rejestracja', 'AuthController@register');
$router->get('/rejestracja-info', 'AuthController@registerInfo');
$router->get('/aktywacja-konta', 'AuthController@activate');
$router->get('/logowanie', 'AuthController@login');
$router->get('/odzyskiwanie-hasla', 'AuthController@recoverPassword');
$router->get('/odzyskiwanie-hasla-info', 'AuthController@recoverPasswordInfo');
$router->get('/reset-hasla', 'AuthController@resetPassword');
$router->get('/reset-hasla-info', 'AuthController@resetPasswordInfo');
$router->get('/panel', 'DashboardController@index');
$router->get('/api/get-date', 'DashboardController@getDate');
$router->get('/user/avatar', 'DashboardController@getAvatar');

//POST
$router->post('/user/register', 'AuthController@store');
$router->post('/user/login', 'AuthController@authenticate');
$router->post('/user/avatar', 'DashboardController@sendAvatar');
$router->post('/user/logout', 'AuthController@logout');
$router->post('/user/recover-password', 'AuthController@sendRecoverToken');
$router->post('/user/reset-password', 'AuthController@editPassword');
$router->post('/user/change-password', 'DashboardController@changePassword');
$router->post('/api/send-date', 'DashboardController@sendDate');
$router->post('/api/add-todo', 'DashboardController@addTodo');
$router->post('/api/edit-todo', 'DashboardController@editTodo');
$router->post('/api/delete-todo', 'DashboardController@removeTodo');
$router->post('/api/check-todo', 'DashboardController@checkTodo');
