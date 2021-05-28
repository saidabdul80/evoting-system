<?php
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VotingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('/home', function () {
    return view('home');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/get_posts', [PostController::class, 'getAllPost']);
Route::post('/get_aspirants', [PostController::class, 'getAspirants']);

Route::post('/check_eligibility', [PostController::class, 'checkEligility']);
Route::post('/submit_elect', [PostController::class, 'submitElect']);



Route::post('/register', [RegisterController::class, 'create'])->name('register');
Route::get('/register', [RegisterController::class,'index']);
Route::middleware(['authlogin'])->group(function(){

	Route::get('/voters_inputs', [VotingController::class, 'votersInputs']);
	Route::get('/all_aspirants_vote', [VotingController::class, 'allAspirantsVotes']);
	Route::get('/results',function(){
		return view('results');
	});
	Route::get('/voting', [VotingController::class, 'index'])->name('voting');
	Route::get('/dashboard', [VotingController::class, 'dashboard'])->name('dashboard');

});
