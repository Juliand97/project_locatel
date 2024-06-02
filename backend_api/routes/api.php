<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//routes bank_account ctrl
Route::post("/state_account","App\http\Controllers\BankAccountController@show_info_account");


//routes BankMovements ctrl
Route::post("/deposit","App\http\Controllers\BankMovementsController@store");
Route::post("/withdrawal","App\http\Controllers\BankMovementsController@withdrawal");

//routes clientes ctrl
Route::post("/new_client","App\http\Controllers\ClientsController@store");
Route::get("/info_client","App\http\Controllers\ClientsController@show");
Route::post("/edit_client","App\http\Controllers\ClientsController@update");
