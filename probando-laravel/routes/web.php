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

Route::get('/hola-mundo', function() {
	return view('hola-mundo');
});

Route::post('/hola-mundo', function() {
	return ('Hola amigo, soy CAPD!');
});

//coincider con metodo descrito
/*Route::match(['get', 'post'], 'contacto', function() {
	return view('contacto');
});*/

//Sirve para cualquier metodo http
/*Route::any('contacto', function() {
	return view('contacto');
});*/

//Pasando parametros a la url, capturandolos en funcion anonima y pasando a la vista. El parametro en la url puede ser opcional indicandolo con ? y dejarle a la funcion un valor por defecto. Tambien se pueden validar los parametros
Route::get('contacto/{nombre?}/{edad?}', function($nombre = "Hola amigo :D", $edad = null) {
	/*return view('contacto', array(
		"nombre" => $nombre,
		"edad" => $edad
	));*/
	return view('contacto.contacto')
				->with('nombre', $nombre)
				->with('edad', $edad)
				->with('frutas', array('naranja', 'pera', 'sandia', 'fresa', 'melon', 'pina'));
})->where([
	'nombre' => '[A-Za-z]+',
	'edad' => '[0-9]+'
]);

/*
Route::get('/frutas', 'FrutasController@index');
Route::get('/naranjas', 'FrutasController@naranjas');
Route::get('/peras', 'FrutasController@peras');
*/
//RUTAS RESTFUL. controller() hara que los metodos de nuestro controlador tengan ruta asignada anteponiendo el metodo http a utilizar
//Route::controller('frutas', 'FrutasController');//Error por la version de laravel
//Route::resource('frutas', 'FrutasController');

/*
Route::get('/frutas', 'FrutasController@index');
Route::get('/naranjas/{admin?}', [
	'middleware' => 'esAdmin',
	'uses' => 'FrutasController@naranjas'
]);
Route::get('/peras', 'FrutasController@peras');
*/

Route::group(['prefix' => 'fruteria'], function() {
	Route::get('/frutas', 'FrutasController@index');
	//Se le puede poner nombre a las rutas
	Route::get('/naranjas/{admin?}', [
		'middleware' => 'esAdmin',
		'uses' => 'FrutasController@naranjas',
		'as' => 'naranjitas',
	]);
	Route::get('/peras', 'FrutasController@peras');
});

Route::post('/recibir', 'FrutasController@recibirFormulario');

Route::resource('notas', 'NotesController');
