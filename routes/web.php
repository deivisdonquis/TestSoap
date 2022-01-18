<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {    return view('welcome'); });

//rurta servidor SOAP
Route::name('server')->get('server','SoapServerController@index');
Route::name('server')->post('server','SoapServerController@index');

//Rutas de pruebas y deteccion de errores
Route::resource('billetera','WalletController');
Route::name('registro')->get('registro','WalletController@registro'); 
Route::name('recargar')->get('recargar','WalletController@recargar'); 
Route::name('consultar')->get('consultar','WalletController@consultar'); 
Route::name('pagar')->get('pagar','WalletController@pagar'); 
Route::name('confirmar')->get('confirmar','WalletController@confirmar'); 
Route::name('probaremail')->get('probaremail','WalletController@probaremail'); 

////////////////////
//rutas de pruebas del cliente soap
Route::name('cliente-getdate')->get('cliente-getdate','SoapClientController@getDate');
Route::name('cliente-getdate')->post('cliente-getdate','SoapClientController@getDate');

Route::name('cliente-consultar')->get('cliente-consultar','SoapClientController@consultar');
Route::name('cliente-consultar')->post('cliente-consultar','SoapClientController@consultar');

Route::name('cliente-registro')->post('cliente-registro','SoapClientController@registro');
Route::name('cliente-registro')->get('cliente-registro','SoapClientController@registro');

Route::name('cliente-recargar')->post('cliente-recargar','SoapClientController@recargar');
Route::name('cliente-recargar')->get('cliente-recargar','SoapClientController@recargar');

Route::name('cliente-pagar')->post('cliente-pagar','SoapClientController@pagar');
Route::name('cliente-pagar')->get('cliente-pagar','SoapClientController@pagar');

Route::name('cliente-confirmar')->post('cliente-confirmar','SoapClientController@confirmar');
Route::name('cliente-confirmar')->get('cliente-confirmar','SoapClientController@confirmar');


