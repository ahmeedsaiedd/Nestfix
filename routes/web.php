<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Models\Category;

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
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/
', function () {
    return view('dashboard');
})->name('dashboard');

route::get('redirect', [HomeController::class, 'redirect']);

Route::get('/home', [AdminController::class, 'index'])->name('admin.home');
Route::get('/home', [TicketController::class, 'dashboard'])->name('admin.home');

Route::get('download/{filename}', [TicketController::class, 'download'])->name('file.download');

Route::get('/moderator/home', [ModeratorController::class, 'index'])->name('moderator.home');

Route::get('/operator/home', [OperatorController::class, 'index'])->name('operator.home');

// routes/web.php
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/inbox', [InboxController::class, 'index'])->name('inbox');
// Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');

// Route for adding a new ticket
Route::get('/add-ticket', [TicketController::class, 'create'])->name('add-ticket');

Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');

// Route for displaying all tickets
// Route::get('/all-tickets', [TicketController::class, 'all'])->name('all-tickets');
Route::get('/admin/all-tickets', [TicketController::class, 'index'])->name('admin.all-tickets');


// Route for displaying active tickets
Route::get('/active-tickets', [TicketController::class, 'active'])->name('active-tickets');

// Route to show the create user form
Route::get('/admin.create-user', [UserController::class, 'create'])
    ->name('create-user')
    ->middleware('check.password');
// Route::get('/create-user ', [UserController::class, 'create'])->name('create-user');
// Route to manage users
Route::get('/manage-users', [UserController::class, 'manage'])->name('manage-users');

// Route::get('/add-category', [CategoryController::class, 'create'])->name('add-category');

// Route::post('/add-category', [CategoryController::class, 'store'])->name('add-category');

// Route::get('/add-category', [CategoryController::class, 'showAddCategoryForm'])->name('admin.add-category');
// Route::get('/add-category', [TicketController::class, 'create'])->name('add-category');


Route::get('/add-ticket', [TicketController::class, 'create'])->name('add-ticket');
Route::get('/add-category', [CategoryController::class, 'showAddCategoryForm'])->name('showAddCategoryForm');

Route::post('/add-category', [TicketController::class, 'storeCategory'])->name('add-category');

// In your routes/web.php or routes/admin.php file
Route::get('/notification', [TicketController::class, 'notification'])->name('admin.notification');

Route::get('/all-tickets', [TicketController::class, 'index'])->name('all-tickets');

Route::get('/add-team', [TicketController::class, 'createTeam'])->name('add-team');
Route::post('/store-team', [TicketController::class, 'storeTeam'])->name('store-team');


Route::get('/tickets/{id}', [TicketController::class, 'show']);

Route::get('/download-image/{trace_id}', [TicketController::class, 'downloadImage'])->name('download.image');


// Route to handle the "Add Team" form submission
Route::post('/add-team', [TicketController::class, 'storeTeam'])->name('store-team');

Route::get('/add-status', [TicketController::class, 'showAddStatusForm'])->name('add-status');

// Route to handle the form submission for adding a new status
Route::post('/add-status', [TicketController::class, 'storeStatus'])->name('store-status');

// Other routes...




// Display the users table
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Change user role
Route::put('/users/{user}/change-role', [UserController::class, 'changeRole'])->name('users.changeRole');

// Delete user
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Display the reset password form
// Route to show the reset password form
Route::get('/users/{user}/reset-password', [UserController::class, 'showResetPasswordForm'])->name('users.resetPasswordForm');

// Route to handle the password reset
Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

// Route to handle the password reset
Route::put('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');

Route::post('/users/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
Route::post('/users/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');

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

Route::get('/dashboard', [TicketController::class, 'dashboard'])->name('dashboard');

Route::get('/exportfilter', [TicketController::class, 'exportfilter'])->name('exportfilter');
// routes/web.php
Route::get('/export', [ExportController::class, 'exportTickets'])->name('tickets.export');
// routes/web.php
Route::get('/export-active-tickets', [TicketController::class, 'exportActiveTickets'])->name('export.active.tickets');
Route::get('/export-all-tickets', [TicketController::class, 'exportAllTickets'])->name('export.all.tickets');



Route::get('/profile', function () {
    return view('admin/profile');
})->name('profile');

Route::get('/admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
Route::put('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');


Route::get('/notifications', [AdminController::class, 'showNotifications'])->name('notifications');

// In web.php
Route::post('/password/verify', [AdminController::class, 'verifyPassword'])->name('password.verify');

// return redirect()->route('admin.notification')->with('admin.notification', session('admin.notification'));

// Route::get('/notify',[\app\http\Controllers\HomeController::class,'notify']);

// Route::post('/validate-admin-password', [AdminController::class, 'validateAdminPassword'])
//     ->name('validate.admin.password');

Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

Route::get('/add-provider', [AdminController::class, 'createProvider'])->name('add-provider');

// Define the route for storing the new provider
Route::post('/store-provider', [AdminController::class, 'storeProvider'])->name('store-provider');

Route::post('/confirm-action', [AdminController::class, 'confirmAction'])->name('confirm.action');

// In your web.php routes file
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories', [CategoryController::class, 'showAddCategoryForm'])->name('categories.index');

Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('delete-category');
Route::delete('/providers/{id}', [TicketController::class, 'destroyProvider'])->name('delete-provider');
Route::delete('/statuses/{id}', [TicketController::class, 'destroystatus'])->name('destroy-status');
Route::delete('/teams/{id}', [TicketController::class, 'destroyteam'])->name('destroy-team');

Route::get('/search', [AdminController::class, 'search'])->name('search');

Route::get('password/reset/{token}', [UserController::class, 'showResetForm'])
    ->name('password.reset');


Route::get('/register', [AdminController::class, 'showRegistrationForm'])
    ->middleware('check.admin.password');

Route::post('/register', [AdminController::class, 'register'])
    ->middleware('check.admin.password');

Route::get('/create-user', [AdminController::class, 'create'])
    ->middleware('check.admin.password');

Route::post('/create-user', [AdminController::class, 'store'])
    ->middleware('check.admin.password');
