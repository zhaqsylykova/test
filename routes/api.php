<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\AiController;

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

Route::get('/stories', [StoryController::class, 'index']);
Route::get('/stories/{id}', [StoryController::class, 'show']);
Route::post('/stories', [StoryController::class, 'store']);

Route::post('/chapters', [ChapterController::class, 'store']);
Route::post('/actions', [ChapterController::class, 'storeAction']);
Route::get('/chapters/{id}', [ChapterController::class, 'show']);
Route::get('/stories/{story_id}/chapters', [ChapterController::class, 'showChapters']);

Route::post('/results', [ResultController::class, 'store']);
Route::get('/results/{id}', [ResultController::class, 'show']);

Route::post('/ai/generate-chapter', [AiController::class, 'generateChapter']);
