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
// Usuarios no auntentificados
Route::group(['middleware' => ['guest']], function () {


    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');


});

// Usuarios auntentificados
Route::group(['middleware' => ['auth']], function () {

    Route::get('/dashboard', 'DashboardController');
    Route::post('/notification/get', 'NotificationController@get');

    Route::get('/main', function () {
        return view('contenido.contenido');
    })->name('main');

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['Almacenero']], function () {
        // rutas de categorias
        Route::get('/categoria', 'CategoriesController@index');
        Route::get('/categoria/selectCategoria', 'CategoriesController@selectCategoria');
        Route::post('/categoria/registrar', 'CategoriesController@store');
        Route::put('/categoria/actualizar', 'CategoriesController@update');
        Route::put('/categoria/desactivar', 'CategoriesController@desactivar');
        Route::put('/categoria/activar', 'CategoriesController@activar');
        Route::get('/categoria/listarPdf', 'CategoriesController@listarPdf');


        // rutas de articulos
        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf');

        // rutas de proveedores
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        // rutas de ingresos
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/listarPdf', 'IngresoController@listarPdf');

    });

    Route::group(['middleware' => ['Vendedor']], function () {
        // rutas de cliente
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        // rutas de ventas
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/listarPdf', 'VentaController@listarPdf');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');


        // rutas de articulo
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');

    });

    Route::group(['middleware' => ['Administrador']], function () {
        // rutas de categorias
        Route::get('/categoria', 'CategoriesController@index');
        Route::get('/categoria/selectCategoria', 'CategoriesController@selectCategoria');
        Route::post('/categoria/registrar', 'CategoriesController@store');
        Route::put('/categoria/actualizar', 'CategoriesController@update');
        Route::put('/categoria/desactivar', 'CategoriesController@desactivar');
        Route::put('/categoria/activar', 'CategoriesController@activar');
        Route::get('/categoria/listarPdf', 'CategoriesController@listarPdf');

        // rutas de articulos
        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
        Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf');



        // rutas de proveedores
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        // rutas de cliente
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');


        // rutas de ventas
        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/listarPdf', 'VentaController@listarPdf');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');

        // rutas de roles
        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');

        // rutas de usuarios
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/activar', 'UserController@activar');
        Route::put('/user/desactivar', 'UserController@desactivar');

        // rutas de ingresos
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');
        Route::get('/ingreso/listarPdf', 'IngresoController@listarPdf');

    });
});