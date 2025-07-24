<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BansosController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DisabilitasController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UserController;
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

// Grup route yang butuh login
Route::middleware(['auth'])->group(function () {
      // Halaman utama
      Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

      // Disabilitas
      Route::get('/disabilitas', [DisabilitasController::class, 'index'])->name('disabilitas');
      Route::get('/disabilitas/add', [DisabilitasController::class, 'addForm'])->name('warga.add');
      Route::post('/disabilitas/store', [DisabilitasController::class, 'store'])->name('warga.store');
      Route::get('/disabilitas/edit/{id}', [DisabilitasController::class, 'edit'])->name('warga.edit');
      Route::put('/disabilitas/update/{id}', [DisabilitasController::class, 'update'])->name('warga.update');
      Route::delete('/disabilitas/{id}', [DisabilitasController::class, 'destroy'])->name('warga.destroy');

      Route::get('/get-kelurahan', [DisabilitasController::class, 'GetKelurahan'])->name('get.kelurahan');

      Route::get("/report", [LaporanController::class, 'index'])->name('report.show');

      // Yatim & Lansia pakai resource controller
      Route::resource('yatim', YatimController::class);
      Route::resource('lansia', LansiaController::class);
      Route::resource('user', UserController::class);
      Route::resource('bansos', BansosController::class);
      Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
      Route::post('/laporan', [LaporanController::class, 'show'])->name('laporan.show');

      //export excel
      Route::get('/export-warga', [LaporanController::class, 'exportCsv'])->name('export.warga');

      Route::put('/warga/status/{id}/{status}', [DisabilitasController::class, 'updateStatus'])->name('warga.updateStatus');

});


Route::middleware('guest')->group(function(){
      Route::get('/',[AuthController::class, 'index'])->name('login');
      Route::post('/login', [AuthController::class, 'login'])->name('validate-login');
});
