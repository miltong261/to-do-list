<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('/show_deleted', [\App\Http\Controllers\Api\V1\TaskController::class, 'showDeletedRecords']);
        Route::get('/show_deleted_by_id/{id}', [\App\Http\Controllers\Api\V1\TaskController::class, 'showDeletedRecord']);

        Route::delete('destroy', [\App\Http\Controllers\Api\V1\TaskController::class, 'destroy']);
        Route::delete('destroy_by_id/{id}', [\App\Http\Controllers\Api\V1\TaskController::class, 'destroyById']);

        Route::patch('change_status/{id}', [\App\Http\Controllers\Api\V1\TaskController::class, 'changeStatus']);

        Route::patch('restore', [\App\Http\Controllers\Api\V1\TaskController::class, 'restore']);
        Route::patch('restore_by_id/{id}', [\App\Http\Controllers\Api\V1\TaskController::class, 'restoreById']);

        Route::get('/', [\App\Http\Controllers\Api\V1\TaskController::class, 'index']);

        Route::get('{id}', [\App\Http\Controllers\Api\V1\TaskController::class, 'show']);

        Route::post('/', [\App\Http\Controllers\Api\V1\TaskController::class, 'store']);

        Route::put('{id}', [\App\Http\Controllers\Api\V1\TaskController::class, 'update']);
    });
});
