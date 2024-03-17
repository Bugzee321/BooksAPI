<?php

use App\Http\Controllers\API\BooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/books/{isbn}', [BooksController::class, 'show']);
// Route::get('/books/{isbn}', function ($isbn) {
//     dd($isbn);
//     // If validation fails, Laravel will automatically return a JSON response with error messages
//     return app()->call('App\Http\Controllers\API\BooksController@show', ['isbn' => $isbn]);
// })->middleware('App\Http\Requests\ShowBookRequest');