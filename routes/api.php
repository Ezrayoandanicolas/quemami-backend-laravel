<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Role;

// Controller
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    $role = Role::find($user->roles);
    $user->roles = $role->role;

    return $user;
});

Route::post('menus', [ProductController::class, 'menus']);
Route::get('landing-page', [DashboardController::class, 'index']);


Route::middleware('auth:sanctum')->group( function () {
    Route::get('product', [ProductController::class, 'index']);
    Route::post('product/add-product', [ProductController::class, 'store']);
    Route::post('product/update-product/{id}', [ProductController::class, 'update']);
    Route::delete('product/delete-product/{id}', [ProductController::class, 'destroy']);

    Route::get('category', [CategoryController::class, 'index']);

    Route::get('user/manage-users/{search}', [UserController::class, 'index']);
    Route::post('user/add-user', [UserController::class, 'store']);
    Route::post('user/update-user/{id}', [UserController::class, 'update']);
    Route::delete('user/delete-user/{id}', [UserController::class, 'destroy']);

    Route::get('roles', [RoleController::class, 'index']);

    Route::get('setting/logo', [SettingController::class, 'indexLogo']);
    Route::post('setting/logo/{id}', [SettingController::class, 'updateLogo']);
    Route::post('setting/logo-title/{id}', [SettingController::class, 'updateLogoTitle']);
    Route::delete('setting/logo/{id}', [SettingController::class, 'destroyLogo']);

    Route::get('setting/menu', [SettingController::class, 'indexMenu']);
    Route::post('setting/menu/{id}', [SettingController::class, 'UpdateMenu']);
    Route::post('setting/menu-text/{id}', [SettingController::class, 'UpdateMenuText']);
    Route::delete('setting/menu/{id}', [SettingController::class, 'destroyMenu']);

    Route::get('setting/social', [SettingController::class, 'indexSocial']);
    Route::post('setting/social/{id}', [SettingController::class, 'updateSocial']);
    Route::delete('setting/social/{id}', [SettingController::class, 'destroySocial']);

    Route::post('logout', [logoutController::class, 'logout']);
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
