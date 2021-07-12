<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Users
Route::post('/user', [UserController::class, 'createUser']);
Route::post('/user/login', [UserController::class, 'login']);

//Notes
Route::get('/notes', [NotesController::class, 'getAllNotes']);
Route::get('/notes/{userID}', [NotesController::class, 'getNotes']);
Route::post('/notes', [NotesController::class, 'createNote']);
Route::put('/notes', [NotesController::class, 'updateNote']);
Route::delete('/notes/{noteID}', [NotesController::class, 'deleteNote']);