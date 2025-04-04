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
use App\Http\Controllers\GmailLoginAuthController;
use App\Http\Controllers\GmailAuthController;
use App\Http\Controllers\FacebookAuthController;
use App\Http\Controllers\WhatsAppAuthController;
use Illuminate\Support\Facades\Storage;



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
Route::get('/auth/google-login/{type}', [GmailLoginAuthController::class, 'redirectToGoogleLogin'])->name('google-login.auth');
Route::get('/auth/google-login-callback', [GmailLoginAuthController::class, 'handleGoogleLoginCallback']);

Route::get('/auth/google', [GmailAuthController::class, 'redirectToGoogle'])->name('gmail.auth');
Route::get('/auth/callback', [GmailAuthController::class, 'handleGoogleCallback']);
// Route::get('/gmail/messages', [GmailAuthController::class, 'getMessages'])->name('gmail.messages');
// Route::get('/gmail/inbox', [GmailAuthController::class, 'getMessages'])->name('gmail.inbox');

	//WhatsApp inbox
	Route::get('/whatsapp/webhook', [WhatsAppAuthController::class, 'receiveWhatsAppMessages']);

Route::get('/auth/facebook', [FacebookAuthController::class, 'redirectToFacebook'])->name('facebook.auth');
Route::get('/facebook/callback', [FacebookAuthController::class, 'handleFacebookCallback']);

Route::get('/download/{filename}', function ($filename) {
    $filePath = public_path('uploads/chat-files/' . $filename);

    if (file_exists($filePath)) {
        return response()->download($filePath);
    } else {
        abort(404);
    }
})->name('file.download');


Route::get('/', [ProfileController::class, 'welcome']);

Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/employee-dashboard', [DashboardController::class, 'employee_dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('employee-dashboard');

Route::get('/client-dashboard', [DashboardController::class, 'client_dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('client-dashboard');		


Route::middleware('auth')->group(function () {
	//ChangePassword
	Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');
	Route::post('/change-password', [ChangePasswordController::class, 'save_data'])->name('change-password-save');
	
	//My Profile Page
	Route::get('/my-profile', [MyProfileController::class, 'index'])->name('my-profile');
	
	//Chat Page
	Route::get('/chat', [ChatController::class, 'chatPage'])->name('chat');
	Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
	Route::post('/send-rason-message', [ChatController::class, 'sendRasonMessage'])->name('send.reason-message');
	//Route::get('/chat/{receiverId}', [ChatController::class, 'chatWithUser'])->name('chat.with');
	Route::post('/message-delete', [ChatController::class, 'message_delete'])->name('message.delete');
	Route::get('/chat/latest-users', [ChatController::class, 'getChatUsers'])->name('chat.users');
	Route::get('/chat/updateReadStatus', [ChatController::class, 'update_chat_read_status'])->name('chat.update.readstatus');
	//Route::get('/chat/{receiverId}', [ChatController::class, 'chatPage'])->name('chat.page');
	
	Route::get('/shared-chat', [ChatController::class, 'shared_chat'])->name('shared-chat');
	Route::get('/ticket-chat', [ChatController::class, 'ticket_chat'])->name('ticket-chat');
	Route::post('/ticket-message-list', [ChatController::class, 'ticket_chat_list'])->name('ticket-message-list');
	Route::post('/ticket-send-message', [ChatController::class, 'ticket_send_message'])->name('ticket-send-message');
	
	//Channel list
	Route::get('/channel', [ChatController::class, 'channel_list'])->name('channel');
	
	//Gmail inbox
	Route::get('/gmail-inboxes', [GmailAuthController::class, 'getMessages'])->name('gmail-inboxes');
	Route::post('/send-reply', [GmailAuthController::class, 'sendReply'])->name('send.reply');
	
	//Facebook inbox
	Route::get('/facebook-pages', [FacebookAuthController::class, 'getPages'])->name('facebook-pages');
	Route::get('/facebook-inboxes/{pageId}', [FacebookAuthController::class, 'getMessages'])->name('facebook-inboxes');
	Route::post('/facebook/conversation', [FacebookAuthController::class, 'getConversationMessages'])->name('facebook-conversation');
	Route::post('/facebook/send-message', [FacebookAuthController::class, 'sendMessage']);
	// Route::get('/facebook/pages', [FacebookAuthController::class, 'getPages']);
	// Route::get('/facebook/messages/{pageId}', [FacebookAuthController::class, 'getMessages']);


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
	
	// client dashboard 
	Route::get('start-new-chat', [DashboardController::class,'start_new_chat'])->name('start-new-chat');
	Route::get('open-new-chat/{slug}/{unique_chat_id}', [ChatController::class,'open_new_chat'])->name('open-new-chat');
	
});



require __DIR__.'/auth.php';
