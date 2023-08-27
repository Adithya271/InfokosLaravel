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
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\RekeningController;

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

Route::post('registerpemilik', [AuthController::class, 'registerpemilik']);
Route::post('registerpencari', [AuthController::class, 'registerpencari']);
Route::post('resetpassword', [AuthController::class, 'resetPassword']);
Route::get('registerpemilik/confirmationpemilik/{id}', [AuthController::class, 'confirmationpemilik']);
Route::get('registerpencari/confirmation/{id}', [AuthController::class, 'confirmation']);
Route::post('loginpemilik', [AuthController::class, 'loginpemilik']);
Route::post('loginpencari', [AuthController::class, 'loginpencari']);
Route::post('loginadmin', [AuthController::class, 'loginadmin']);

Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

//
Route::post('/useradmin', [UserAdminController::class, 'store']);
Route::put('/useradmin/{id}', [UserAdminController::class, 'update']);
Route::delete('/useradmin/{id}', [UserAdminController::class, 'destroy']);
Route::delete('/userpemilik/{id}', [UserPemilikController::class, 'destroy']);
Route::post('/userpencari', [UserPencariController::class, 'store']);
Route::put('/userpencari/{id}', [UserPencariController::class, 'update']);
Route::delete('/userpencari/{id}', [UserPencariController::class, 'destroy']);
Route::post('/iklan', [IklanController::class, 'store']);
Route::put('/iklan/{id}', [IklanController::class, 'update']);
Route::delete('/iklan/{id}', [IklanController::class, 'destroy']);
Route::post('/jeniskos', [JenisKosController::class, 'store']);
Route::put('/jeniskos/{id}', [JenisKosController::class, 'update']);
Route::delete('/jeniskos/{id}', [JenisKosController::class, 'destroy']);
Route::post('/kecamatan', [KecamatanController::class, 'store']);
Route::put('/kecamatan/{id}', [KecamatanController::class, 'update']);
Route::delete('/kecamatan/{id}', [KecamatanController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['middleware' => 'useradmin'], function () { });

    Route::group(['middleware' => 'userpemilik'], function () { });
});

Route::get('/useradmin', [UserAdminController::class, 'index']);

Route::put('/penginapan/{id}', [PenginapanController::class, 'update']);
Route::delete('/penginapan/{id}', [PenginapanController::class, 'destroy']);
Route::post('/penginapan', [PenginapanController::class, 'store']);

Route::get('/userpemilik', [UserPemilikController::class, 'index']);
Route::post('/userpemilik', [UserPemilikController::class, 'store']);
Route::put('/userpemilik/{id}', [UserPemilikController::class, 'update']);
Route::put('/updaterekeningpemilik/{id}', [UserPemilikController::class, 'updateRekeningPemilik']);
Route::post('/userpemilik', [UserPemilikController::class, 'store']);
Route::put('/userpemilik/{id}', [UserPemilikController::class, 'update']);
Route::put('/updateprofilepemilik/{id}', [UserPemilikController::class, 'updateProfilePemilik']);
Route::get('/getprofile/{id}', [UserPemilikController::class, 'getProfile']);

Route::get('/jeniskos', [JenisKosController::class, 'index']);

Route::get('/iklan', [IklanController::class, 'index']);
Route::get('/iklan/{id}', [IklanController::class, 'show']);

Route::get('/favorit', [FavoritController::class, 'index']);

Route::get('/kecamatan', [KecamatanController::class, 'index']);

Route::get('/penginapan', [PenginapanController::class, 'index']);
Route::get('/promokos', [PenginapanController::class, 'getPromoKos']);
Route::get('/allkos', [PenginapanController::class, 'getAllKos']);
Route::get('/carikos', [PenginapanController::class, 'cariKos']);
Route::get('/belumpublish', [PenginapanController::class, 'belumPublish']);
Route::get('/sudahpublish', [PenginapanController::class, 'sudahPublish']);

Route::get('/userpencari', [UserPencariController::class, 'index']);
Route::get('/getprofile', [UserPencariController::class, 'getProfile']);
Route::put('/updateprofilepencari/{id}', [UserPencariController::class, 'updateProfilePencari']);

Route::post('/favorit', [FavoritController::class, 'store']);
Route::put('/favorit/{id}', [FavoritController::class, 'update']);
Route::delete('/favorit/{namaKos}/{emailPenambah}', [FavoritController::class, 'destroy']);

Route::get('/images/{filename}', function ($filename) {
    $path = 'public/images/' . $filename;

    if (!Storage::exists($path)) {
        abort(404);
    }

    $file = Storage::get($path);
    $type = Storage::mimeType($path);

    $response = response($file, 200)->header('Content-Type', $type);
    return $response;
});

Route::post('uploadimage', [ImageController::class, 'uploadImage']);

Route::get('/lokasi', [LokasiController::class, 'index']);
Route::post('/lokasi', [LokasiController::class, 'store']);
Route::put('/lokasi/{id}', [LokasiController::class, 'update']);
Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy']);
Route::post('/lokasiupdate', [LokasiController::class, 'storeOrUpdate']);

Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::post('/transaksi', [TransaksiController::class, 'store']);
Route::post('/konfirmasibooking/{id}', [TransaksiController::class, 'konfirmasibooking'])->name('konfirmasibooking');
Route::post('/sudahcheckin/{id}', [TransaksiController::class, 'sudahcheckin'])->name('sudahcheckin');
Route::post('/pemesanbatalbooking/{id}', [TransaksiController::class, 'PemesanBatalBooking']);
Route::post('/pemilikbatalbooking/{id}', [TransaksiController::class, 'PemilikBatalBooking']);
Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy']);

Route::get('/rekening', [RekeningController::class, 'index']);
Route::post('/rekening', [RekeningController::class, 'store']);
Route::put('/rekening/{id}', [RekeningController::class, 'update']);
Route::delete('/rekening/{id}', [RekeningController::class, 'destroy']);
