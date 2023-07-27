<?php
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    //create User account
    Route::post('/register', [AuthController::class, 'createAccount']);
    //socialAuth
    Route::post('/socialAuth', [AuthController::class, 'socialAuth']);

    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });

    //create Super Admin account
    Route::post('/createSuperAdmin', [AuthController::class, 'createSuperAdmin']);


    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/changePassword', [AuthController::class, 'changePassword']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/deleteAdmin', [AdminController::class, 'deleteAdmin']);


        // routes accessible only to SuperAdmin
        Route::group(['middleware' => 'superadmin'], function () {
            //user/admin registration
            Route::post('/createAdminUser', [AuthController::class, 'createAdminUser']);
            Route::get('/getAdmins', [AdminController::class, 'getAdmins']);
            Route::get('/suspendAdmin', [AdminController::class, 'suspendAdmin']);
            Route::get('/unsuspendAdmin', [AdminController::class, 'unsuspendAdmin']);
        });

        // routes accessible only to Staff and SuperAdmin
        Route::group(['middleware' => 'staff'], function () {
            //
            Route::get('/getUsers', [AdminController::class, 'getUsers']);
            // Route::get('/getAdmins', [AdminController::class, 'getAdmins']);
        });
    });
});
