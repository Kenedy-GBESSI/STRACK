<?php

use App\Http\Controllers\Candidacies\CandidacyController;
use App\Http\Controllers\Companies\CompanyController;
use App\Http\Controllers\Companies\CompanyRegisterController;
use App\Http\Controllers\Companies\StudentInternController;
use App\Http\Controllers\Files\SystemFilePondController;
use App\Http\Controllers\InternShips\InternShipController;
use App\Http\Controllers\Offers\OfferController;
use App\Http\Controllers\Offers\OfferForStudentController;
use App\Http\Controllers\Students\DashboardStudentController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Students\StudentExportController;
use App\Http\Controllers\Students\StudentInternShipController;
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

    // Offers
    Route::resource('offers', OfferController::class);

    Route::middleware(['checkProfileType:App\Models\Institute'])->group(function () {

        Route::get('dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('institute.dashboard');

        // Students
        Route::get('students/export', StudentExportController::class)->name('students.export');
        Route::resource('students', StudentController::class)->only('index', 'show');
        Route::post('final-note-for-student/{student_intern_ship}', [StudentController::class, 'gradeStudent'])->name('students.update-final-note');

        // Company
        Route::resource('companies', CompanyController::class)->except('create', 'update', 'store', 'edit');
        Route::post('/companies/{company}/reject', [CompanyController::class, 'rejectCompany'])->name('companies.reject-company');
        Route::post('/companies/{company}/validate', [CompanyController::class, 'validateCompany'])->name('companies.validate-company');
    });

    Route::middleware(['checkProfileType:App\Models\Company'])->group(function () {

        Route::get('dashboard/company', function () {
            return Inertia::render('Companies/Dashboard');
        })->name('company.dashboard');


        // Candidacies
        Route::get('candidacies', [CandidacyController::class, 'getCandidaciesForCompany'])->name('candidacies');
        Route::get('candidacies/{candidacy}', [CandidacyController::class, 'showCandidacy'])->name('candidacies.show');
        Route::post('/candidacies/{candidacy}/reject', [CandidacyController::class, 'rejectCandidacy'])->name('candidacies.reject-company');
        Route::post('/candidacies/{candidacy}/validate', [CandidacyController::class, 'validateCandidacy'])->name('candidacies.validate-company');


        // Interns
        Route::get('interns', [StudentInternController::class, 'getInternsForCompany'])->name('interns');
        Route::get('interns/{student_intern_ship}', [StudentInternController::class, 'showIntern'])->name('interns.show');
        Route::post('company-note-for-intern/{student_intern_ship}', [StudentInternController::class, 'gradeIntern'])->name('interns.update-note');
        Route::post('/intern/{student_intern_ship}/reject-rapport-file', [StudentInternController::class, 'rejectRapportFile'])->name('interns.reject-rapport-file');
        Route::post('/intern/{student_intern_ship}/validate-rapport-file', [StudentInternController::class, 'validateRapportFile'])->name('interns.validate-rapport-file');
    });

    Route::middleware(['checkProfileType:App\Models\Student'])->group(function () {

        Route::get('dashboard/students', DashboardStudentController::class)->name('student.dashboard');

        Route::get('get-offers-for-students', [OfferForStudentController::class, 'getOffersForStudent'])->name('students.offers');
        Route::post('/apply-to-offer/{student}/{offer}', [CandidacyController::class, 'toApplyOffer'])->name('students.to-apply-offer');

        Route::get('/start-intern-ship/{student}/{offer}', [StudentInternShipController::class, 'startInternShip'])->name('students.start-intern-ship');

        Route::post('/student-intern-ship/{student_intern_ship}/rapport', [StudentInternShipController::class, 'saveRapportFile'])->name('students.send-rapport');

    });



    // Filepond integration
    Route::get('filepond/api/process', [SystemFilePondController::class, 'show'])->name('filepond.show');
    Route::delete('filepond/api/process', [SystemFilePondController::class, 'delete'])->name('filepond.destroy');
});
