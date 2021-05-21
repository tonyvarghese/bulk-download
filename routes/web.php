<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DownloadController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('download', [DownloadController::class, 'download'])->middleware(['auth'])->name('download');

Route::get('download-zip/{id}', [DownloadController::class, 'downloadZip'])->middleware(['auth'])->name('download.zip');
