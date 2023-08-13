<?php


use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JenisKosController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\PenginapanController;
use App\Http\Controllers\UserAdminController;
use App\Http\Controllers\UserPemilikController;
use App\Http\Controllers\UserPencariController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;
use App\Http\Resources\PaginationResource;

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

Route::get('/login', [AuthController::class, 'showLoginAdminForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginadmin'])->name('loginadmin');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::group(['middleware' => 'useradmin'], function () {

    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::delete('/userpemilik/{id}', [UserPemilikController::class, 'destroy'])->name('pemilik.destroy');
    Route::get('/userpemilik', [UserPemilikController::class, 'index'])->name('pemilik.index');
    Route::get('/userpemilik/{id}/edit', [UserPemilikController::class, 'edit'])->name('pemilik.edit');
    Route::put('/userpemilik/{id}', [UserPemilikController::class, 'update'])->name('pemilik.update');
    Route::get('/searchpemilik', [UserPemilikController::class, 'search'])->name('searchpemilik');

    Route::delete('/userpencari/{id}', [UserPencariController::class, 'destroy'])->name('pencari.destroy');
    Route::get('/userpencari', [UserPencariController::class, 'index'])->name('pencari.index');
    Route::post('/userpencari/tambah', [UserPencariController::class, 'store'])->name('pencari.store');
    Route::get('/userpencari/{id}/edit', [UserPencariController::class, 'edit'])->name('pencari.edit');
    Route::put('/userpencari/{id}', [UserPencariController::class, 'update'])->name('pencari.update');
    Route::get('/searchpencari', [UserPencariController::class, 'search'])->name('searchpencari');

    Route::delete('/penginapan/{id}', [PenginapanController::class, 'destroy'])->name('penginapan.destroy');
    Route::get('/penginapan', [PenginapanController::class, 'index'])->name('penginapan.index');
    Route::post('/penginapan/setuju/{id}', [PenginapanController::class, 'setuju'])->name('penginapan.setuju');
    Route::post('/penginapan/tolak/{id}', [PenginapanController::class, 'tolak'])->name('penginapan.tolak');
    Route::get('/searchpenginapan', [PenginapanController::class, 'search'])->name('searchpenginapan');

    Route::delete('/iklan/{id}', [IklanController::class, 'destroy'])->name('iklan.destroy');
    Route::get('/iklan', [IklanController::class, 'index'])->name('iklan.index');
    Route::post('/iklan', [IklanController::class, 'store'])->name('iklan.store');

    Route::get('/logout', [AuthController::class, 'logoutadmin'])->name('logout');


});
