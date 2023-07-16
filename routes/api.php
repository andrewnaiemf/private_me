<?php

use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\PlanController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\SuggestionController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\DirectoryController;
use App\Http\Controllers\API\UploadUserDataController;
use App\Http\Controllers\API\FriendShipController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return $request->user();
});


Route::group([

    'prefix' => 'auth'

], function () {

    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::post('forget_password', [AuthController::class, 'forgetPassword']);

    Route::get('questions',[QuestionController::class, 'index' ]);

});


Route::group([

    'middleware' => 'auth:api',
    'prefix' => 'auth'

], function () {

    Route::get('logout',  [AuthController::class, 'logout']);
    Route::post('refresh',  [AuthController::class, 'refresh']);
    Route::post('change_password' ,  [AuthController::class, 'changepassword']);

    Route::get('me' ,  [UserController::class, 'me']);
    Route::post('user' ,  [UserController::class, 'update']);
    Route::delete('user/{id}' ,  [UserController::class, 'destroy']);

    Route::resource('plan' ,  PlanController::class);

    Route::resource('package' ,  PackageController::class);
    Route::post('package/cancel' ,[PackageController::class, 'cancel' ]);

    Route::resource('directory' ,  DirectoryController::class);

    Route::resource('upload' ,  UploadUserDataController::class);
    Route::put('file/{id}' ,  [UploadUserDataController::class, 'renameFile']);

    Route::resource('chat', ChatController::class);

    Route::post('suggestion',[SuggestionController::class, 'store' ]);

    Route::get('friend/friend_request/{id}' ,   [FriendShipController::class, 'sendFriendRequest']);
    Route::get('friend/search/{name}' ,   [FriendShipController::class, 'search']);
    Route::put('friend/action/{id}', [FriendShipController::class, 'update']);
});
