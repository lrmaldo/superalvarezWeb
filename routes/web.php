<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('sucursal','SucursalController');

/* rutas de perfil */
Route::get('/perfil', array('as' => 'perfil', 'uses' => 'SucursalController@perfil'));
Route::put('/perfil/update/{id}',array('as'=>'perfil.update','uses'=>'SucursalController@perfilUpdate'));

/* rutas del banner principal */

Route::resource('bannerp','bannerprincipalController');

/* rutas de productos */
Route::resource('productos','ProductosController');

/* rutas de categorias */
Route::resource('categorias','CategoriasController');
