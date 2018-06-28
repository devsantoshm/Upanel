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
    return view('contenido.contenido');
});

#region
    // rutas de categorias
    Route::get('/categoria', 'CategoriesController@index');
    Route::get('/categoria/selectCategoria', 'CategoriesController@selectCategoria');
    Route::post('/categoria/registrar', 'CategoriesController@store');
    Route::put('/categoria/actualizar', 'CategoriesController@update');
    Route::put('/categoria/desactivar', 'CategoriesController@desactivar');
    Route::put('/categoria/activar', 'CategoriesController@activar');
#endregion

#region
    // rutas de articulos
    Route::get('/articulo', 'ArticuloController@index');
    Route::post('/articulo/registrar', 'ArticuloController@store');
    Route::put('/articulo/actualizar', 'ArticuloController@update');
    Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
    Route::put('/articulo/activar', 'ArticuloController@activar');
#endregion

#region
    // rutas de cliente
    Route::get('/cliente', 'ClienteController@index');
    Route::post('/cliente/registrar', 'ClienteController@store');
    Route::put('/cliente/actualizar', 'ClienteController@update');
#endregion

#region
    // rutas de proveedores
    Route::get('/proveedor', 'ProveedorController@index');
    Route::post('/proveedor/registrar', 'ProveedorController@store');
    Route::put('/proveedor/actualizar', 'ProveedorController@update');
#endregion

#region
    // rutas de proveedores
    Route::get('/rol', 'RolController@index');
    Route::post('/rol/registrar', 'RolController@store');
    Route::put('/rol/actualizar', 'RolController@update');
#endregion