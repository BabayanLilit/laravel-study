<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::get('/', ['as' => 'department.grid', 'uses' => 'Department@grid']);

Route::resource('department', 'Department', ['only' => [
    'index',
    'create',
    'store',
    'update',
    'edit',
    'destroy'
]]);

Route::resource('employee', 'Employee', ['only' => [
    'index',
    'create',
    'store',
    'update',
    'edit',

    'destroy'
]]);

Auth::routes();

Route::get('/home', 'HomeController@index');


Menu::make('mainMenu', function($menu){

    $menu->add('Сетка',     ['route'  => 'department.grid']);
    $menu->add('Сотрудники',     ['route'  => 'employee.index']);
    $menu->add('Отделы',    ['route'  => 'department.index']);

});