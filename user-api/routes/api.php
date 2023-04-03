<?php

use App\Http\Controllers\StudentController;
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
:wq
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('student/getAll', [StudentController::class, 'index']);
Route::post('student/create', [StudentController::class, 'createNewStudent']);
Route::get('student/getStudent/{id}', [StudentController::class, 'getStudentById']);
Route::put('student/update/{id}', [StudentController::class, 'updateStudent']);
Route::put('student/delete/{id}', [StudentController::class, 'deleteStudent']);
