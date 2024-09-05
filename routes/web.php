<?php

use App\Http\Controllers\Companies\CompanyController;
use App\Http\Controllers\Companies\CompanyRegisterController;
use App\Http\Controllers\Files\SystemFilePondController;
use App\Http\Controllers\InternShips\InternShipController;
use App\Http\Controllers\Offers\OfferController;
use App\Http\Controllers\Offers\OfferForStudentController;
use App\Http\Controllers\Students\StudentController;
use Illuminate\Http\Request;
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

Route::redirect('/', '/login');
Route::get('/company-register-view', [CompanyRegisterController::class, 'companyRegisterView'])->name('company-register-view');
Route::post('/company-register', [CompanyRegisterController::class, 'companyRegister'])->name('company-register');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/home', function (Request $request) {

        switch ($request->user()->role) {
            case 'Institute':
                return redirect(route('institute.dashboard'));
            case 'Company':
                return redirect(route('company.dashboard'));
            case 'Student':
                return redirect(route('student.dashboard'));
            default:
                abort(404);
        }
    })->name('home');

    // InternShips
    Route::resource('intern-ships', InternShipController::class);

    Route::middleware(['checkProfileType:App\Models\Institute'])->group(function () {

        Route::get('dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('institute.dashboard');

        // Students
        Route::resource('students', StudentController::class)->only('index', 'show');

        // Company
        Route::resource('companies', CompanyController::class)->except('create', 'update', 'store', 'edit');
        Route::post('/companies/{company}/reject', [CompanyController::class, 'rejectCompany'])->name('companies.reject-company');
        Route::post('/companies/{company}/validate', [CompanyController::class, 'validateCompany'])->name('companies.validate-company');
    });

    Route::middleware(['checkProfileType:App\Models\Company'])->group(function () {

        Route::get('dashboard/company', function () {
            return Inertia::render('Companies/Dashboard');
        })->name('company.dashboard');


        // Offers
        Route::resource('offers', OfferController::class);
    });

    Route::middleware(['checkProfileType:App\Models\Student'])->group(function () {

        Route::get('dashboard/students', function () {
            return Inertia::render('Students/Dashboard');
        })->name('student.dashboard');

        Route::get('get-offers-for-students', [OfferForStudentController::class, 'getOffersForStudent'])->name('students.offers');

    });



    // Filepond integration
    Route::get('filepond/api/process', [SystemFilePondController::class, 'show'])->name('filepond.show');
    Route::delete('filepond/api/process', [SystemFilePondController::class, 'delete'])->name('filepond.destroy');
});
