<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UserController;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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
    return redirect()->route('login');
});

Route::get('/confirm-password', function () {
    return view('auth.confirm-password');
})->middleware('auth')->name('password.confirm');

Route::post('/confirm-password', function (Request $request) {
    if (! Hash::check($request->password, $request->user()->password)) {
        return back()->withErrors([
            'password' => ['The provided password does not match our records.']
        ]);
    }

    $request->session()->passwordConfirmed();

    return redirect()->intended();
})->middleware(['auth', 'throttle:6,1']);

Route::get('login',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('login',[AuthController::class,'postLogin'])->name('post.login')->middleware('guest');
Route::get('register',[AuthController::class,'register'])->name('register')->middleware('guest');
Route::post('register',[AuthController::class,'postRegister'])->name('post.register')->middleware('guest');
Route::get('forgot',[AuthController::class,'forgot'])->name('forgot')->middleware('throttle:global')->middleware('guest');
Route::post('forgot',[AuthController::class,'postForgot'])->name('post.forgot')->middleware('guest');

Route::get('/reset-password/{token}', function ($token) {
    return view('user.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password',[AuthController::class,'updatePassword'])
->middleware('guest')
->name('password.update');

Route::post('email/verification-notification',[AuthController::class,'verificationNotification'])
->middleware(['auth','throttle:6,1'])
->name('verification.send');

Route::get('/email/verify',function(){
    return view('user.verify-email');
})->middleware('auth')->name('verification.notice');

// Auth::routes([
//     'verify'=>true
// ]);

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/select.branch');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::get('select-branch',[ProfileController::class,'selectBranch'])->name('select.branch')->middleware(['auth.admin']);
Route::post('post-branch',[ProfileController::class,'postBranch'])->name('post.branch')->middleware('auth');

Route::group(['middleware'=>['auth.admin','throttle:global','verified','auth.branch']],function() {

    Route::get('dashboard',[ProfileController::class,'index'])->name('dashboard');
    Route::get('users',[UserController::class,'index'])->name('users');
    Route::get('user-list',[UserController::class,'userList'])->name('user.list');
    Route::get('logout',[UserController::class,'logout'])->name('user.logout');
    Route::get('stock-take',[StockController::class,'index'])->name('stock.take');
    Route::post('stock-create',[StockController::class,'stockCreate'])->name('stock.create');
    Route::get('stock-edit/{id}',[StockController::class,'stockEdit'])->name('stock.edit');
    Route::post('stock-update',[StockController::class,'stockUpdate'])->name('stock.update');
    Route::get('upload-edit/{id}',[StockController::class,'uploadEdit'])->name('upload.edit');
    Route::get('stock-delete',[StockController::class,'stockDelete'])->name('stock.delete');
    Route::get('destroy-stock',[StockController::class,'destroyStock'])->name('destroy.stock');
    Route::get('destroy-upload',[StockController::class,'destroyUpload'])->name('destroy.upload');
    Route::get('data-settings',[StockController::class,'dataSettings'])->name('data.settings');
    Route::get('trash-stock',[StockController::class,'trashStock'])->name('trash.stock')->middleware(['password.confirm']);
    Route::get('trash-upload',[StockController::class,'trashUpload'])->name('trash.upload')->middleware(['password.confirm']);
    Route::post('upload-update',[StockController::class,'uploadUpdate'])->name('upload.update');
    Route::get('upload-delete',[StockController::class,'uploadDelete'])->name('upload.delete');
    Route::get('taken-list',[StockController::class,'stockTakenList'])->name('taken.list');
    Route::get('stock-fetch',[StockController::class,'fetch'])->name('stock.fetch');
    Route::get('stock-select',[StockController::class,'selectData'])->name('stock.select');
    Route::get('manual/search',[StockController::class,'manualSearch'])->name('manual.search');
    Route::get('manual/exist',[StockController::class,'chechExistence'])->name('manual.exist');
    Route::get('excel-import',[ExcelImportController::class,'index'])->name('excel.import');
    Route::get('import-list',[StockController::class,'ImportList'])->name('import.list');
    Route::get('import-fetch',[StockController::class,'importFetch'])->name('import.fetch');
    Route::post('user-import',[ExcelImportController::class,'userImport'])->name('user.import');
    Route::get('excel-export',[ExcelImportController::class,'exportReport'])->name('excel.export');
    Route::get('excel-export-form1',[ExcelImportController::class,'exportReportForm1'])->name('excel.form1');
    Route::get('excel-export-form2',[ExcelImportController::class,'exportReportForm2'])->name('excel.form2');
    Route::get('stock-report',[ReportController::class,'index'])->name('stock.report');
    Route::get('report/format-one',[ReportController::class,'formatOne'])->name('format.one');
    Route::get('report/format-two',[ReportController::class,'formatTwo'])->name('format.two');
});


