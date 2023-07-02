<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TodoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [TodoController::class,'dashboard'])->name('dashboard');

    Route::get('/todos',[TodoController::class,'getTodosForUser'])->name('todos');

    Route::get('/todos/create',[TodoController::class,'getTodoForm'])->name('todos.create');

    Route::post('/todos/create',[TodoController::class,'storeTodo'])->name('todos.store');

    Route::get('/todos/{id}',[TodoController::class,'show'])->name('todos.view');

    Route::get('/todos/{id}/edit',[TodoController::class,'getEditForm'])->name('todos.edit');

    Route::put('/todos/{id}/edit',[TodoController::class,'update'])->name('todos.update');

    Route::delete('/todos/{id}',[TodoController::class,'destroy'])->name('todos.delete');

    Route::get('/todos/{id}/activity/change',[TodoController::class,'changeActivity'])->name('todos.activity.change');

    Route::get('/todos/{id}/finish',[TodoController::class,'finish'])->name('todos.finish');

    Route::get('/todos/{id}/comments',[CommentController::class,'todoComments'])->name('todos.comments');

    Route::post('/comments/{todoId}/create',[CommentController::class,'create'])->name('comments.create');

    Route::delete('/comments/{id}',[CommentController::class,'destroy'])->name('comments.delete');

});
