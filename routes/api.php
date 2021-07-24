<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\SQLDBDumpController;
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

Route::group(['prefix' => 'v1'], function () {
    Route::get('/dumpDb', [SQLDBDumpController::class, 'dumpDB']);

    /*
       |--------------------------------------------------------------------------
       | AUTHENTICATION ROUTES
       |--------------------------------------------------------------------------
       */

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:api']], function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
        /*
        |--------------------------------------------------------------------------
        | BOARD ROUTES
        |--------------------------------------------------------------------------
        */
        Route::group(['prefix' => 'board'], function () {
            Route::get('/', [BoardController::class, 'index']);
            Route::post('/', [BoardController::class, 'create']);
            Route::put('/{boardId}', [BoardController::class, 'update']);
            Route::get('/{boardId}', [BoardController::class, 'show']);
            Route::delete('/{boardId}', [BoardController::class, 'destroy']);

            /*
             |--------------------------------------------------------------------------
             | List ROUTES
             |--------------------------------------------------------------------------
             */

            Route::get('/{boardId}/list', [ListController::class, 'index']);
            Route::post('/{boardId}/list', [ListController::class, 'create']);
            Route::put('/{boardId}/list/{list}', [ListController::class, 'update']);
            Route::get('/{boardId}/list/{list}', [ListController::class, 'show']);
            Route::delete('/{boardId}/list/{list}', [ListController::class, 'destroy']);

            /*
            |--------------------------------------------------------------------------
            | Card ROUTES
            |--------------------------------------------------------------------------
            */

            Route::get('/{boardId}/list/{list}/card', [CardController::class, 'index']);
            Route::post('/{boardId}/list/{list}/card', [CardController::class, 'create']);
            Route::put('/{boardId}/list/{list}/card/{card}', [CardController::class, 'update']);
            Route::get('/{boardId}/list/{list}/card/{card}', [CardController::class, 'show']);
            Route::delete('/{boardId}/list/{list}/card/{card}', [CardController::class, 'destroy']);


        });

    });

});
