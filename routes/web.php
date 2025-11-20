<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InviteController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/home');
    }
    return view('auth.signup');
});

Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('showRegister');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');

Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');

Route::get('/invite/{token}', [InviteController::class, 'acceptInvite'])->name('team.acceptInvite');


Route::middleware('auth')->group(function () {

    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/home', [TeamController::class, 'index'])->name('home');

    Route::post('/teams/destroy', [TeamController::class, 'destroy'])->name('deleteTeam');
    Route::post('/teams/create', [TeamController::class, 'store'])->name('createTeam');

    Route::get('/team/{team}', [TeamController::class, 'view'])->name('viewTeam');

    Route::post('/team/{team}/invite', [InviteController::class, 'createInvite'])->name('team.invite');

    Route::post('/team/{team}/createTask', [TaskController::class, 'createTask'])->name('createTask');
    Route::post('/team/{team}/deleteTask', [TaskController::class, 'deleteTask'])->name('deleteTask');
});
