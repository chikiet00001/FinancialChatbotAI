<?php
// routes/web.php
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerChatbotAI;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerUpdateUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\User;


use Illuminate\Http\Request;

Route::get('/chatbotai', [ControllerChatbotAI::class, 'index'])->name('chatbotai');

// Route xử lý form đăng nhập
Route::get('/chatbotai/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/chatbotai/login', [AuthController::class, 'login']);
//=======================================================

// Route xử lý form đăng ký
Route::get('/chatbotai/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/chatbotai/register', [AuthController::class, 'register']);
//=======================================================

Route::get('/chatbotai/admin', [ControllerAdmin::class, 'admin'])->name('admin');
Route::post('/chatbotai/admin', function(){
    return redirect('/chatbotai/admin');
})->name('admindisplay');

Route::get('/', function () {
    // return view('home');
    return redirect('/chatbotai');
});

Route::post('/logout', function () {
    Auth::logout();                  // Xoá session đăng nhập
    request()->session()->invalidate(); // Xoá toàn bộ session
    request()->session()->regenerateToken(); // Tạo CSRF token mới

    return redirect('/chatbotai/login'); // hoặc về trang chủ
})->name('logout');


// Xử lý API
Route::post('/chatbotai/demo', [ControllerChatbotAI::class, 'fetchFastAPI'])->name('fetchFastAPI');
Route::get('/chatbotai/demo', [AuthController::class, 'demo']); 

//  =====   xử lý manager admin     ======
//  Route getAllUsers   =====
Route::get('/chatbotai/admin', [ControllerAdmin::class, 'getAllUsers'])->name('chatbotai.manager.admin');
//  Route createUserManager
Route::post('/chatbotai/admin', [ControllerAdmin::class, 'userstore'])->name('userstore');
//  Route updateUserManager 
Route::put('/chatbotai/admin', [ControllerAdmin::class, 'updateUser'])->name('userupdate');  
// routes/web.php
Route::delete('/chatbotai/admin/{id}', [ControllerAdmin::class, 'destroyUser'])->name('userdelete');


// API bắt đầu tác vụ

Route::post('/chatbotai/admin/UpdateStart', [ControllerAdmin::class, 'UpdateStarted'])->name('UpdateStart');
