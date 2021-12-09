<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterRoleController;
use App\Http\Controllers\MasterPenggunaController;
use App\Http\Controllers\ConfigAppController;
use App\Http\Controllers\ProfilController;

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
Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

AdvancedRoute::controllers([
	'profil' => ProfilController::class
]);

Route::prefix('admin')->group(function () {
	AdvancedRoute::controllers([
		'master-roles' => MasterRoleController::class,
		'master-pengguna' => MasterPenggunaController::class,
		'config-app' => ConfigAppController::class,
	]);
});

Auth::routes();