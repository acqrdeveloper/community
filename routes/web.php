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

/*
 ** NOMBRES VISTAS **
 * view-list
 * view-detail
 * view-create
 * view-edit
 * view-change-tipo
 */


/*
 *
 ** NOMBRES CONTROLADORES **
 * get-list
 * store
 * edit
 * update
 * change-tipo
 */

Route::group(['middleware' => ['auth', 'web']], function () {

    // HOME
    Route::get('/', function () {
        return redirect()->to("/home");
    });
    Route::get('/home', 'Controller@viewVue');

    // ACTIVIDAD
    Route::get('/actividad-all', 'ActividadController@getList');

    // EMPRESA
    Route::get('/empresa-create', 'Controller@viewVue');
    Route::get('/empresa-all', 'EmpresaController@all');

    // PERSONA
    Route::get('/personas', 'Controller@viewVue');
    Route::get('/persona-create', 'Controller@viewVue');
    Route::get('/persona-all', 'PersonaController@all');
    Route::get('/cliente-all', 'PersonaController@allClientes');
    Route::post('/persona/store', 'PersonaController@store');
    Route::get('/persona-edit/{id}', 'PersonaController@edit');
    Route::get('/persona-show/{id}', 'PersonaController@edit');
    Route::put('/persona-update/{id}', 'PersonaController@update');
    Route::put('/persona-change-status/{id}', 'PersonaController@changeStatus');
    Route::get('/persona-filter', 'PersonaController@filter');

    // COMPROBANTE PAGO
    Route::get('/comprobantes', 'Controller@viewVue');
    Route::get('/comprobante-create', 'Controller@viewVue');
    Route::get('/comprobante-all', 'ComprobanteController@all');
    Route::post('/comprobante-store', 'ComprobanteController@store');
    Route::put('/comprobante-update/{id}', 'ComprobanteController@update');
//    Route::post('/comprobante-edit','ComprobanteController@edit');
//    Route::post('/comprobante-pay','ComprobanteController@pay');
//    Route::post('/comprobantes-by-usuario','ComprobanteController@allByUsuario');
//    Route::post('/comprobante-change-status','ComprobanteController@changeStatus');


    // ACTIVIDAD
    Route::get('/list-actividades', 'Controller@viewVue');
    Route::get('/create-update-actividad', 'Controller@viewVue');
    Route::get('/detalle-actividad', 'Controller@viewVue');
    Route::get('/get-actividades', 'Controller@getActividades');
    Route::get('/filtro-especificado', 'ActividadController@filterEspecified');

    // TABLAS MANTENIMIENTO
    Route::get('/tablas', 'Controller@viewVue');
    Route::get('/tablas-load', 'TablasController@load');
    Route::get('/tablas-all', 'TablasController@all');
    Route::post('/tablas-store/{tabla}', 'TablasController@store');
    Route::put('/tablas-update/{tabla}/{id}', 'TablasController@update');

    // LOGOUT
    Route::get('logout', 'Auth\LoginController@logout');

});

Route::group(['middleware' => ['guest']], function () {

    // SESSION
    Route::get('login', 'Auth\LoginController@showLoginForm');
    Route::post('post/login', 'Auth\LoginController@fnDoLogin');

});