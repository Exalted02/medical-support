<?php

use Illuminate\Http\Request;

use App\Http\Controllers\LangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\EmailManagementController;
use App\Http\Controllers\EmailSettingsController;
use App\Http\Controllers\MyProfileController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\RegisteredUserController;

use App\Http\Controllers\ChatController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('clear-cache', function () {
    \Artisan::call('config:cache');
    \Artisan::call('cache:clear');
	\Artisan::call('cache:clear');
    // \Artisan::call('route:cache');
    \Artisan::call('view:clear');
    \Artisan::call('config:cache');
    \Artisan::call('optimize:clear');
	Log::info('Clear all cache');
    dd("Cache is cleared");
});
Route::get('db-migrate', function () {
    \Artisan::call('migrate');
    dd("Database migrated");
});
Route::get('db-seed', function () {
    \Artisan::call('db:seed');
    dd("Database seeded");
});
Route::get('/', [ProfileController::class, 'welcome']);

Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
	


Route::middleware('auth')->group(function () {
	//ChangePassword
	Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');
	Route::post('/change-password', [ChangePasswordController::class, 'save_data'])->name('change-password-save');
	
	//My Profile Page
	Route::get('/my-profile', [MyProfileController::class, 'index'])->name('my-profile');
	
	//Chat Page
	Route::get('/chat', [ChatController::class, 'index'])->name('chat');
	Route::get('/ticket-chat', [ChatController::class, 'ticket_chat'])->name('ticket-chat');

	//EmailSettings
	Route::get('/email-settings', [EmailSettingsController::class, 'index'])->name('user.email-settings');
	Route::post('/email-settings', [EmailSettingsController::class, 'save_data'])->name('email-settings-save');
	
	
	
// Email Management Routes
	Route::get('email-management', [EmailManagementController::class,'index'])->name('email-management');
	Route::get('/email-management-edit/{id}', [EmailManagementController::class, 'email_management_edit'])->name('email-management-edit');
	Route::post('/email-management-edit-save',[EmailManagementController::class,'manage_email_management_process'])->name('email-management-edit-save');
	
	// account- remove 
	Route::get('account-remove', [CommonController::class,'account_remove'])->name('account-remove');
	Route::post('account-remove', [CommonController::class,'save_account_remove'])->name('account-remove');
	Route::get('account-remove-list', [CommonController::class,'account_remove_list'])->name('account-remove-list');
	Route::post('remove-account-update-status', [CommonController::class,'account_remove_update_status'])->name('remove-account-update-status');
	Route::post('remove-account-delete', [CommonController::class,'remove_account_delete'])->name('remove-account-delete');
	
});



require __DIR__.'/auth.php';
