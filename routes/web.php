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


/* rutas de banners de sucursal */

Route::resource('banners','bannerSucursalController');

/*  rutas de pedidos de sucursal */
Route::resource('pedidos','PedidosController');

/* rutas de telegram */
Route::resource('telegram','TelegramController');

/* clientes app */
Route::resource('clientes','ClientesController');

Route::get('documentacion',function (){
return view('documentacion');
})->name('documentacion');

Route::get('pedidospdf/{id}','PedidosController@generate_pdf');

Route::get('clear_cache', function () {

    \Artisan::call('cache:clear');

    dd("Cache is cleared");

});


Route::get('config_cache', function () {

    \Artisan::call('config:cache');

    dd("Config and Cache is cleared");

});

Route::get('clear_route', function () {

    \Artisan::call('route:clear');

    dd("Route is cleared");

});

Route::get('view_cache', function () {

    \Artisan::call('view:clear');

    dd("View is cleared");

});

/* get pdf */

Route::get('get_pdf/{filename}', function ($filename)
{
    $path = storage_path('app/public/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});