<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Disp\DispController;
use App\Http\Controllers\Input\InputController;

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

Route::get('/', [LoginController::class, 'init']);

// http://127.0.0.1/laraveltest/xxx/xxxをグループ化
Route::prefix('laraveltest')->group(function () {

	Route::get('/pinfo', function () {
		return view('pages.pinfo');
	});

	// http://127.0.0.1/laraveltest/login/xxxをグループ化
	Route::group(['prefix' => 'login', 'as' => 'login.'],  function () {
		Route::get('/init', [LoginController::class, 'init'])->name('init');
		Route::post('/auth', [LoginController::class, 'auth'])->name('auth');
		Route::get('/lift', [LoginController::class, 'lift'])->name('lift');
	});

	// http://127.0.0.1/laraveltest/disp or input/xxxで認証を行う
	Route::group(['middleware' => 'auth'], function () {

		// http://127.0.0.1/laraveltest/disp/xxxをグループ化
		Route::group(['prefix' => 'disp', 'as' => 'disp.'],  function () {
			Route::get('/init', [DispController::class, 'init'])->name('init');
			Route::post('/search', [DispController::class, 'search'])->name('search');
			Route::post('/page', [DispController::class, 'page'])->name('page');
			Route::post('/edit', [DispController::class, 'edit'])->name('edit');
			Route::get('/complete', [DispController::class, 'complete'])->name('complete');
		});

		// http://127.0.0.1/laraveltest/input/xxxをグループ化
		Route::group(['prefix' => 'input', 'as' => 'input.'],  function () {
			Route::get('/new', [InputController::class, 'new'])->name('new');
			Route::get('/edit', [InputController::class, 'edit'])->name('edit');
			Route::post('/regist', [InputController::class, 'regist'])->name('regist');
			Route::post('/delete', [InputController::class, 'delete'])->name('delete');
			Route::get('/back', function () {
				return redirect(route('disp.init'));
			})->name('back');
		});
	});
});
