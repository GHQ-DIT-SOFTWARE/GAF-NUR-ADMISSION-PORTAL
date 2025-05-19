<?php

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AuditController;

use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\Front\ApplicantPreview\CorrectApplicantController;
use App\Http\Controllers\Front\OfferingCourse\OfferingCourseController;
use App\Http\Controllers\Front\Dashboard\DashboardController;

use App\Http\Controllers\Front\Portal\AcceptanceController;
use App\Http\Controllers\Front\Portal\ApplicantPdfGenerationController;
use App\Http\Controllers\Front\Portal\BiodataController;
use App\Http\Controllers\Front\Portal\EducationController;
use App\Http\Controllers\Front\Portal\PersonnelPortalInfoController;
use App\Http\Controllers\Front\Portal\ProfessionController;

use App\Http\Controllers\LogactivityController;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PortalLogin;
use App\Http\Controllers\QrCodeController;

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

Route::get('/Portal', [PortalLogin::class, 'showPortalForm'])->name('portal.login');
Route::get('/Verify-Otp', [PortalLogin::class, 'verify'])->name('verify-otp');
Route::post('/otp', [PortalLogin::class, 'verifyOtp'])->name('otp-for-initial-login');
Route::post('/Portal', [PortalLogin::class, 'apply'])->name('portal.apply');

Route::get('/Reprint-Verify-Otp', [PortalLogin::class, 'verify_reprint_summary_report_otp'])->name('report-verify-otp');
Route::post('/otp-for-summary-sheet-reprint', [PortalLogin::class, 'verifyOtpreprint'])->name('otp-for-reprint');
Route::get('/Print/Summary/Sheet', [PortalLogin::class, 'PrintSummarySheet'])->name('print-summary-sheet');
Route::post('/summary-sheet', [PortalLogin::class, 'print_summary_sheet'])->name('print-summary');

// Portal landing page after login
Route::middleware(['portal'])->group(function () {
    // Route::post('/summary-sheet', [PortalLogin::class, 'print_summary_sheet'])->name('print-summary');
    Route::get('/apply/{step?}', [PersonnelPortalInfoController::class, 'index'])->name('portal-apply');
    Route::prefix('applicant')->group(function () {
        Route::get('/bio-data', [BiodataController::class, 'biodata'])->name('bio-data');
        Route::post('save-biodata', [BiodataController::class, 'saveBioData'])->name('saveBioData');
    });
    Route::prefix('education')->group(function () {
        Route::get('/details', [EducationController::class, 'education_details'])->name('education-details');
        Route::post('save-education-data', [EducationController::class, 'saveEducationData'])->name('saveEducationData');
    });
    Route::prefix('profession')->group(function () {
        Route::get('/professional-details', [ProfessionController::class, 'Profession_details'])->name('Profession-details');
        Route::post('save-ProfessionalData', [ProfessionController::class, 'saveProfessionalData'])->name('saveProfessionalData');
    });
    Route::prefix('declaration-and-acceptance')->group(function () {
        Route::get('/preview-data', [AcceptanceController::class, 'preview'])->name('preview');
        Route::post('Declaration-and-Acceptance', [AcceptanceController::class, 'Declaration_and_Acceptance'])->name('declaration-and-acceptance');
    });
    Route::post('/apply-logout', [PortalLogin::class, 'apply_logout'])->name('apply_logout');
    Route::get('/applicant-pdf', [ApplicantPdfGenerationController::class, 'generatePdf'])->name('applicant-pdf');
});
// Default route redirects to Portal login
Route::get('/', function () {
    return redirect()->route('portal.login');
});

// Route::get('/admin/login', function () {
//     return view('auth.login');
// })->name('admin.login');
Auth::routes();
Route::post('/login', [AuthController::class, 'Login'])->name('login');
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::get('/decrypt', [QrCodeController::class, 'decript'])->name('decrypt-applicant');
    Route::post('/qr-code', [QrCodeController::class, 'decryptQrCode'])->name('decrypt-qr-code');


    Route::group(['prefix' => 'applicant-preview', 'as' => 'correct.'], function () {
        Route::get('/{uuid}', [CorrectApplicantController::class, 'applicant_corrections'])->name('correction-applicant-data');
        Route::post('/applicant/corrections/{uuid}', [CorrectApplicantController::class, 'updateApplicantCorrections'])->name('applicant.corrections.update');
    });





    Route::group(['prefix' => 'courses', 'as' => 'course.'], function () {
        Route::get('/', [CourseTypeController::class, 'View'])->name('courses-index');
        Route::get('/mech', [CourseTypeController::class, 'Add'])->name('mech-courses');
        Route::post('/store', [CourseTypeController::class, 'Store'])->name('store-courses');
        Route::get('/edit/{uuid}', [CourseTypeController::class, 'Edit'])->name('edit-courses');
        Route::post('/update{uuid}', [CourseTypeController::class, 'Update'])->name('update-courses');
        Route::get('/delete{uuid}', [CourseTypeController::class, 'Delete'])->name('delete-courses');
        Route::post('/view-courses', [CourseTypeController::class, 'index'])->name('view-courses');
        Route::post('/course/toggle-status/{uuid}', [CourseTypeController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('get-commission-types', [CourseTypeController::class, 'getCommissionTypes'])->name('get-commission-types');
        Route::post('get-branches', [CourseTypeController::class, 'getBranches'])->name('get-branches');
        Route::post('get-courses', [CourseTypeController::class, 'getCourses'])->name('get-courses');
    });



    Route::prefix('audit-trail')->group(function () {
        Route::get('/user-audit', [AuditController::class, 'Audit'])->name('user-audit-trail');
    });
    Route::prefix('audit-trail')->group(function () {
        Route::get('/logs-activities', [LogactivityController::class, 'login_and_logout_activities'])->name('login_and_logout');
    });
});
Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => 'admin'], function () {
    Route::get('/', [DashboardController::class, 'welcomedashboard'])->name('index');
    Route::get('/analysis-dashboard', [DashboardController::class, 'index'])->name('analysis-dashboard');
});




