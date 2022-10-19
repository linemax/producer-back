<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\TeamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('galleries')->controller(GalleryController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::post('{gallery}', 'update');
    Route::post('{gallery}/photo', 'photos');
    Route::post('{gallery}/video', 'videos');
    Route::get('{gallery}', 'show');
    Route::get('{gallery}/photos', 'getphotos');
    Route::get('{gallery}/videos', 'getvideos');
    Route::delete('{gallery}', 'destroy');
});
Route::prefix('videos')->controller(VideoController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::post('{video}', 'update');
    Route::get('{video}', 'show');
    Route::get('{video}/serve', 'serve');
    Route::delete('{video}', 'destroy');
});
Route::prefix('teams')->controller(TeamController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::post('{team}', 'update');
    Route::post('{team}/photo', 'photo');
    Route::get('{team}', 'show');
    Route::delete('{team}', 'destroy');
});
Route::prefix('plans')->controller(PlansController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::post('{plan}', 'update');
    Route::post('{plan}/photo', 'photo');
    Route::get('{plan}', 'show');
    Route::delete('{plan}', 'destroy');
});
Route::prefix('projects')->controller(ProjectController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::post('{project}', 'update');
    Route::post('{project}/photo', 'photo');
    Route::post('{project}/video', 'video');
    Route::post('{project}/galleries', 'galleries');
    Route::get('{project}/galleries', 'getgalleries');
    Route::get('{project}', 'show');
    Route::delete('{project}', 'destroy');
});
Route::prefix('services')->controller(\App\Http\Controllers\ServiceController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::post('{service}', 'update');
    Route::post('{service}/photos', 'photos');
    Route::post('{service}/photo', 'photo');
    // Route::post('{service}/plans', 'plans');
    // Route::get('{service}/plans', 'getplans');
    Route::get('{service}/photo', 'getphoto');
    Route::get('{service}/photos', 'getphotos');
    Route::get('{service}', 'show');
    Route::delete('{service}', 'destroy');
});
Route::prefix('photos')->controller(\App\Http\Controllers\PhotoController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::post('{photo}', 'update');
    Route::post('delete/selected', 'deleteMultiple');
    Route::get('{photo}', 'show');
    Route::get('{photo}/serve', 'serve');
    Route::delete('{photo}', 'destroy');
});
