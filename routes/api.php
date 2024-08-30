<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactFormController;

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

Route::post('/contact-request/general', [ContactFormController::class, 'general']);
Route::post('/contact-request/room', [ContactFormController::class, 'room']);
Route::post('/contact-request/nursery', [ContactFormController::class, 'nursery']);
Route::post('/contact-request/cooperative', [ContactFormController::class, 'cooperative']);



