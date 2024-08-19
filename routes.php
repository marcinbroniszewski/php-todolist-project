<?php

//GET
$router->get('/', 'HomeController@index');
$router->get('/rejestracja', 'AuthController@register');
$router->get('/logowanie', 'AuthController@login');

//POST
$router->post('/rejestracja', 'AuthController@store');