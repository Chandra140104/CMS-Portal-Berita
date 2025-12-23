<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PortalBeritaController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanKasusController;
use App\Http\Controllers\LaporanKasusAdminController;
use App\Http\Controllers\BeritaCommentController;

/*
|--------------------------------------------------------------------------
| AUTH (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/login', 'login')->name('proses-login');
    });

    Route::controller(RegistrasiController::class)->group(function () {
        Route::get('/registrasi', 'index')->name('registrasi');
        Route::post('/registrasi', 'store')->name('proses-registrasi');
    });

});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PORTAL BERITA (PUBLIK)
|--------------------------------------------------------------------------
*/
Route::controller(PortalBeritaController::class)->group(function () {
    Route::get('/', 'index')->name('welcome');
    Route::get('/navbar', 'navbar')->name('navbar');
    Route::get('/semua-berita', 'showAll')->name('semua-berita');
    Route::get('/berita/{slug}', 'show')->name('satu-berita');
    Route::get('/kategori/{id}', 'newsPerCategory')->name('berita-per-kategori');
});

/*
|--------------------------------------------------------------------------
| KOMENTAR BERITA (PUBLIK)
|--------------------------------------------------------------------------
*/
Route::post('/berita/{slug}/komentar', [BeritaCommentController::class, 'store'])
    ->name('berita.komentar.store');

/*
|--------------------------------------------------------------------------
| LAPORAN KASUS NARKOBA (PUBLIK)
|--------------------------------------------------------------------------
| Bisa diakses TANPA LOGIN
*/
Route::get('/laporan-kasus', [LaporanKasusController::class, 'create'])
    ->name('laporan-kasus.create');

Route::post('/laporan-kasus', [LaporanKasusController::class, 'store'])
    ->name('laporan-kasus.store');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (ADMIN + EDITOR)
|--------------------------------------------------------------------------
| Prefix: /admin
| Middleware: auth + hakakses:admin,editor
*/
Route::prefix('admin')
    ->middleware(['auth', 'hakakses:admin,editor'])
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])->name('admin');

        /*
        | KATEGORI
        */
        Route::controller(KategoriController::class)->prefix('kategori')->group(function () {
            Route::get('/', 'index')->name('kategori');
            Route::get('/tambah', 'create')->name('tambah-kategori');
            Route::post('/tambah', 'store')->name('proses-tambah-kategori');
            Route::get('/edit/{id}', 'edit')->name('edit-kategori');
            Route::put('/edit/{id}', 'update')->name('proses-edit-kategori');
            Route::get('/{id}', 'destroy')->name('hapus-kategori');
        });

        /*
        | BERITA
        */
        Route::controller(BeritaController::class)->prefix('berita')->group(function () {
            Route::get('/', 'index')->name('berita');
            Route::get('/show/{id}', 'show')->name('lihat-berita');
            Route::get('/tambah', 'create')->name('tambah-berita');
            Route::get('/checkSlug', 'checkSlug')->name('checkSlug');
            Route::post('/tambah', 'store')->name('proses-tambah-berita');
            Route::get('/edit/{id}', 'edit')->name('edit-berita');
            Route::put('/edit/{id}', 'update')->name('proses-edit-berita');
            Route::get('/{id}', 'destroy')->name('hapus-berita');
        });

        /*
        | PENGGUNA
        */
        Route::controller(UserController::class)->prefix('pengguna')->group(function () {
            Route::get('/', 'index')->name('pengguna');
            Route::get('/tambah', 'create')->name('tambah-pengguna');
            Route::post('/tambah', 'store')->name('proses-tambah-pengguna');
            Route::get('/edit/{id}', 'edit')->name('edit-pengguna');
            Route::put('/edit/{id}', 'update')->name('proses-edit-pengguna');
            Route::get('/{id}', 'destroy')->name('hapus-pengguna');
        });

        /*
        |--------------------------------------------------------------------------
        | LAPORAN KASUS (ADMIN ONLY)
        |--------------------------------------------------------------------------
        */
        Route::middleware('hakakses:admin')->prefix('laporan-kasus')->group(function () {

            Route::get('/', [LaporanKasusAdminController::class, 'index'])
                ->name('admin.laporan-kasus.index');

            // ✅ EXPORT EXCEL
            Route::get('/export', [LaporanKasusAdminController::class, 'exportExcel'])
                ->name('admin.laporan-kasus.export');

            Route::get('/{laporan}', [LaporanKasusAdminController::class, 'show'])
                ->name('admin.laporan-kasus.show');
        });

    });
