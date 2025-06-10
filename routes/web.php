<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DisabilitasController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\YatimController;
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

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
//Disabilitas
Route::get('/disabilitas', [DisabilitasController::class, 'index'])->name('disabilitas');
Route::get('/disabilitas/add', [DisabilitasController::class, 'addForm'])->name('warga.add');
Route::post('/disabilitas/store', [DisabilitasController::class, 'store'])->name('warga.store');
Route::get('/disabilitas/edit/{id}', [DisabilitasController::class, 'edit'])->name('warga.edit');
Route::put('/disabilitas/update/{id}', [DisabilitasController::class, 'update'])->name('warga.update');
Route::delete('/disabilitas/{id}', [DisabilitasController::class, 'destroy'])->name('warga.destroy');

//Yatim Resource
Route::resource('yatim',YatimController::class);

//Lansia Resource
Route::resource('lansia', LansiaController::class);