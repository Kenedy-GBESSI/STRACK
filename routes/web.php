<?php

use App\Http\Controllers\Companies\CompanyController;
use App\Http\Controllers\Companies\CompanyRegisterController;
use App\Http\Controllers\Students\StudentController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/company-register-view', [CompanyRegisterController::class, 'companyRegisterView'])->name('company-register-view');
Route::post('/company-register', [CompanyRegisterController::class, 'companyRegister'])->name('company-register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');


    // Students
    Route::resource('students', StudentController::class)->only('index', 'show');

    // Company
    Route::resource('companies', CompanyController::class)->only('index', 'show', 'update');
});
