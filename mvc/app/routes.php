<?php
/*
 * Este archivo va a contener TODAS las rutas de
 * nuestra aplicación.
 *
 */
use DaVinci\Core\Route;

// Registramos la primer ruta! :D
/* Register */
Route::add('POST', '/users/register', 'UserController@register');
Route::add('PUT', '/auth/users/edit/user', 'UserController@editUser');
Route::add('PUT', '/auth/users/edit/biography', 'UserController@editBiography');

/* Posts */
Route::add('POST', '/auth/posts/create', 'PostController@create');
Route::add('DELETE', '/auth/posts/delete/{id}', 'PostController@delete');
Route::add('GET', '/auth/posts/getByUserId/{id}', 'PostController@byUser');
Route::add('GET', '/auth/posts/{id}', 'PostController@byId');
Route::add('GET', '/auth/posts', 'PostController@getAll');

/* Comentarios */
Route::add('POST', '/auth/comments/create', 'CommentController@create');
Route::add('DELETE', '/auth/comments/delete/{id}', 'CommentController@delete');
Route::add('GET', '/auth/comments/getByPost/{id}', 'CommentController@byPost');

/* Login */
Route::add('POST', '/auth/login', 'AuthController@login');
Route::add('DELETE', '/auth/logout', 'AuthController@logout');
Route::add('GET', '/auth/getAuth', 'AuthController@getAuth');