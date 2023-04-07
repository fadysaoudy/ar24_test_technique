<?php

use App\Http\Controllers\UserDocumentController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('layouts.app');
});
Route::prefix('user')->group(function () {
    //    user info
    Route::get('/', [UsersController::class, 'index'])->name('user.index');
    Route::post('/store', [UsersController::class, 'store'])->name('user.store');
    Route::get('/show', [UsersController::class, 'show'])->name('user.show');
    Route::get('/get', [UsersController::class, 'getUserByMail'])->name('user.get');

    //    user document
    Route::post('/document', [UserDocumentController::class, 'index'])->name('userDocument.store');
    Route::get('/document', [UserDocumentController::class, 'store'])->name('userDocument.index');

    Route::post('/user-email', [UsersController::class, 'sendEmail'])->name('user.sendEmail');
    Route::get('/user-email/{mail_id}', [UsersController::class, 'receiveEmail'])->name('user.receiveEmail');


});
