<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/
dashboard', function () {
    return view('dashboard');
})->name('dashboard');

route::get('redirect', [HomeController::class, 'redirect']);

Route::get('/admin/home', [AdminController::class, 'index'])->name('admin.home');

Route::get('/moderator/home', [ModeratorController::class, 'index'])->name('moderator.home');

Route::get('/operator/home', [OperatorController::class, 'index'])->name('operator.home');

// routes/web.php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/inbox', [InboxController::class, 'index'])->name('inbox');
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

// Route for adding a new ticket
Route::get('/add-ticket', [TicketController::class, 'create'])->name('add-ticket');

// Route for displaying all tickets
Route::get('/all-tickets', [TicketController::class, 'all'])->name('all-tickets');

// Route for displaying active tickets
Route::get('/active-tickets', [TicketController::class, 'active'])->name('active-tickets');

// Route to show the create user form
Route::get('/create-user', [UserController::class, 'create'])->name('create-user');

// Route to manage users
Route::get('/manage-users', [UserController::class, 'manage'])->name('manage-users');

// Display the users table
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Change user role
Route::put('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.changeRole');

// Delete user
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Display the reset password form
Route::get('/users/{user}/reset-password', [UserController::class, 'showResetPasswordForm'])->name('users.resetPasswordForm');

// Handle the password reset
Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

// Other routes remain unchanged
// web.php

Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Show the create user form
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Store a new user
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Display users management
Route::get('/manage-users', [UserController::class, 'manage'])->name('manage-users');

Route::get('/ticket', function () {
    return view('ticket');
});

Route::post('/submit-ticket', [TicketController::class, 'store'])->name('ticket.store');

// Route::get('/admin/all-tickets', [TicketController::class, 'index']);
Route::get('/all-tickets', [TicketController::class, 'index'])->name('all-tickets');

// Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');

// routes/web.php or routes/api.php
Route::patch('/tickets/{id}', [TicketController::class, 'update'])->name('tickets.update');

