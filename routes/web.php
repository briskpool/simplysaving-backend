<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\MotoController;
use App\Http\Controllers\Admin\NbaController;
use App\Http\Controllers\Admin\NFLController;
use App\Http\Controllers\Admin\NRLController;
use App\Http\Controllers\Admin\TableTennisController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\TennisController;
use App\Http\Controllers\Admin\TradeController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UfcController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MyProfile;

use App\Http\Controllers\User\FundsController;
use App\Http\Controllers\User\HelpController;
use App\Http\Controllers\User\SecurityController;
use App\Http\Controllers\User\StatisticsController;
use App\Http\Controllers\User\TradeStatementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

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

// Route::get('/link-storage', function () {
//    Artisan::call('storage:link');
// });

Route::middleware(['auth'])->group(function () {
   Route::get('/', function () {
      return redirect()->route('login');
   });



   Route::resource('clients', ClientController::class)->middleware('admin');

   Route::resource('interests', TradeController::class)->middleware('admin')->except(['show', 'edit', 'update', 'destroy']);

   Route::resource('transactions', TransactionController::class)->middleware('admin');

   Route::get('/account', [MyProfile::class, 'index'])->name('account');
   Route::post('/account/{id}', [MyProfile::class, 'update'])->name('account.update');

   Route::middleware('password.confirm')->group(function () {

      Route::get('/trade-statement', [TradeStatementController::class, 'index'])->middleware('user')->name('trade-statement');

      Route::get('/add-funds', [FundsController::class, 'add_funds'])->middleware('user')->name('add-funds');
      Route::post('/add-funds', [FundsController::class, 'add_funds'])->middleware('user')->name('add-funds.request');

      Route::get('/withdraw-funds', [FundsController::class, 'withdraw_funds'])->middleware(['user','membership'])->name('withdraw-funds');
      Route::post('/withdraw-funds', [FundsController::class, 'withdraw_funds'])->middleware(['user', 'membership'])->name('withdraw-funds.request');
      
      Route::get('/help', [HelpController::class, 'help'])->middleware('user')->name('help');
      Route::post('/help', [HelpController::class, 'help'])->middleware('user')->name('help.request');

      Route::get('/security', [SecurityController::class, 'index'])->middleware('user')->name('security');

      Route::post('/security', [SecurityController::class, 'secure'])->middleware('user')->name('security.update');
   });
});

Auth::routes(['verify' => true]);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
