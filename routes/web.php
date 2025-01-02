<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LembagaController;
use App\Http\Controllers\KegiatanVolunteerController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\BasicController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumentasiController;
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
    if (auth()->check()) {
        return redirect()->route('home');
    }
    $counts = [
        'volunteers' => \App\Models\Volunteer::where('status', 'approved')->count(),
        'campaigns' => \App\Models\KegiatanVolunteer::count(),
        'organizations' => \App\Models\Lembaga::count(),
    ];
    return view('layouts.user_app', compact('counts'));
});


Route::get('/listaktivitas', function () {
    return view('layouts.listaktivitas');
})->name('listaktivitas');

Route::middleware('auth')->group(function() {
    Route::get('/home', function() {
        if (auth()->user()->hasRole('Admin')) {
            return redirect()->action([HomeController::class, 'index']);
        }
        $counts = [
            'volunteers' => \App\Models\Volunteer::where('status', 'approved')->count(),
            'campaigns' => \App\Models\KegiatanVolunteer::count(),
            'organizations' => \App\Models\Lembaga::count(),
        ];
        return view('layouts.user_app', compact('counts'));
    })->name('home');

    Route::get('/admin/home', [HomeController::class, 'index'])->middleware('role:Admin');

    Route::resource('basic', BasicController::class);


    Route::middleware(['role:Admin|Pengurus Lembaga'])->prefix('lembaga')->group(function () {  
        Route::get('/export', [LembagaController::class, 'export'])->name('lembagas.export');
        Route::get('/', [LembagaController::class, 'index'])->name('lembagas.index');  
        Route::get('/create', [LembagaController::class, 'create'])->name('lembagas.create');       
        Route::get('{id}', [LembagaController::class, 'show'])->name('lembagas.show');      
        Route::post('/', [LembagaController::class, 'store'])->name('lembagas.store');      
        Route::get('{id}/edit', [LembagaController::class, 'edit'])->name('lembagas.edit');  
        Route::put('{id}', [LembagaController::class, 'update'])->name('lembagas.update');   
        Route::delete('{id}', [LembagaController::class, 'destroy'])->name('lembagas.destroy');  
    });  

    Route::middleware(['role:Admin|Pengurus Lembaga'])->prefix('kegiatan')->group(function () {  
        Route::get('/export', [KegiatanVolunteerController::class, 'export'])->name('kegiatan_volunteers.export');
        Route::get('/', [KegiatanVolunteerController::class, 'index'])->name('kegiatan_volunteers.index');  
        Route::get('/create', [KegiatanVolunteerController::class, 'create'])->name('kegiatan_volunteers.create');       
        Route::get('{id}', [KegiatanVolunteerController::class, 'show'])->name('kegiatan_volunteers.show');      
        Route::post('/', [KegiatanVolunteerController::class, 'store'])->name('kegiatan_volunteers.store');      
        Route::get('{id}/edit', [KegiatanVolunteerController::class, 'edit'])->name('kegiatan_volunteers.edit');  
        Route::put('{id}', [KegiatanVolunteerController::class, 'update'])->name('kegiatan_volunteers.update');   
        Route::delete('{id}', [KegiatanVolunteerController::class, 'destroy'])->name('kegiatan_volunteers.destroy');  
    });

    Route::middleware(['role:Admin|Pengurus Lembaga|Pengurus Kegiatan'])->prefix('volunteer')->group(function () {  
        Route::get('/export', [VolunteerController::class, 'export'])->name('volunteers.export');
        Route::get('/', [VolunteerController::class, 'index'])->name('volunteers.index');  
        Route::get('/create', [VolunteerController::class, 'create'])->name('volunteers.create');      
        Route::get('{id}', [VolunteerController::class, 'show'])->name('volunteers.show');      
        Route::post('/', [VolunteerController::class, 'store'])->name('volunteers.store');      
        Route::get('{id}/edit', [VolunteerController::class, 'edit'])->name('volunteers.edit');  
        Route::put('{id}', [VolunteerController::class, 'update'])->name('volunteers.update');  
        Route::delete('{id}', [VolunteerController::class, 'destroy'])->name('volunteers.destroy');  
    });

    Route::middleware(['role:Admin|Pengurus Lembaga|Pengurus Kegiatan'])->prefix('review')->group(function () {  
        Route::get('/export', [ReviewController::class, 'export'])->name('reviews.export');
        Route::get('/', [ReviewController::class, 'index'])->name('reviews.index');  
        Route::get('/create', [ReviewController::class, 'create'])->name('reviews.create');      
        Route::get('{id}', [ReviewController::class, 'show'])->name('reviews.show');      
        Route::post('/', [ReviewController::class, 'store'])->name('reviews.store');      
        Route::get('{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');  
        Route::put('{id}', [ReviewController::class, 'update'])->name('reviews.update');  
        Route::delete('{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');  
    });

    Route::middleware(['role:Admin|Pengurus Lembaga|Pengurus Kegiatan'])->prefix('dokumentasi')->group(function () {  
        Route::get('/export', [DokumentasiController::class, 'export'])->name('dokumentasis.export');
        Route::get('/', [DokumentasiController::class, 'index'])->name('dokumentasis.index');  
        Route::get('/create', [DokumentasiController::class, 'create'])->name('dokumentasis.create');      
        Route::get('{id}', [DokumentasiController::class, 'show'])->name('dokumentasis.show');      
        Route::post('/', [DokumentasiController::class, 'store'])->name('dokumentasis.store');      
        Route::get('{id}/edit', [DokumentasiController::class, 'edit'])->name('dokumentasis.edit');  
        Route::put('{id}', [DokumentasiController::class, 'update'])->name('dokumentasis.update');  
        Route::delete('{id}', [DokumentasiController::class, 'destroy'])->name('dokumentasis.destroy');  
    });







});

