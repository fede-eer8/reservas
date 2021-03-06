<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function () {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
Route::get('/usuario', 'AuthController@getUsers');
Route::get('/reserva/{id_sala}/sala/{mes}/mes', 'ReservaController@reservasBySala');
//reservasBySala
Route::apiResource('/sala','SalaController');
Route::apiResource('/reserva','ReservaController');
Route::put('/usuario/{id}', 'AuthController@updateUser');
Route::any('prueba','ReservaController@enviarNotificacion' );