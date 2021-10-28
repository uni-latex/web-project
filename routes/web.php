<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Secure\DashboardController;
use App\Http\Controllers\Secure\DocumentController;
use App\Http\Controllers\Secure\MutationController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents');
    Route::get('/documents/download', [DocumentController::class, 'download'])->name('documents.download');

    Route::get('/mutations', [MutationController::class, 'index'])->name('mutations');
    Route::get('/mutations/download', [MutationController::class, 'download'])->name('mutations.download');

});


Route::get('/test', function () {
    $user = \App\Models\User::find(2);

    $permissions = \App\Models\Permission::all();

    foreach ($permissions as $permission) {
        dump($permission->name . ' -> ' . $user->hasPermissionTo($permission->name) );
    }
});
