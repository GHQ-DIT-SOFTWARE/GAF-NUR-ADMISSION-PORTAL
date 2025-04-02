<?php

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AgeLimitController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CommissionTypeController;
use App\Http\Controllers\CourseTypeController;
use App\Http\Controllers\Front\ApplicantPreview\CorrectApplicantController;
use App\Http\Controllers\Front\OfferingCourse\OfferingCourseController;
use App\Http\Controllers\Front\Dashboard\DashboardController;
use App\Http\Controllers\Front\Phases\AptitudeController;
use App\Http\Controllers\Front\Phases\BasicFitnessTestController;
use App\Http\Controllers\Front\Phases\BodySelectionController;
use App\Http\Controllers\Front\Phases\DocumentationController;
use App\Http\Controllers\Front\Phases\InterviewController;
use App\Http\Controllers\Front\Phases\MedicalsController;
use App\Http\Controllers\Front\Phases\OutDoorLeaderlessTestController;
use App\Http\Controllers\Front\Phases\VettingController;
use App\Http\Controllers\Front\Portal\AcceptanceController;
use App\Http\Controllers\Front\Portal\ApplicantPdfGenerationController;
use App\Http\Controllers\Front\Portal\BiodataController;
use App\Http\Controllers\Front\Portal\EducationController;
use App\Http\Controllers\Front\Portal\PersonnelPortalInfoController;
use App\Http\Controllers\Front\Portal\ProfessionController;
use App\Http\Controllers\Front\Profile\ProfileController;
use App\Http\Controllers\Front\Region\DistrictController;
use App\Http\Controllers\Front\Region\RegionController;
use App\Http\Controllers\Front\Reports\ReportGenerationController;
use App\Http\Controllers\Front\School\BeceResultController;
use App\Http\Controllers\Front\School\BeceSubjectController;
use App\Http\Controllers\Front\School\WassceResultController;
use App\Http\Controllers\Front\School\WassceSubjectController;
use App\Http\Controllers\LogactivityController;
use App\Http\Controllers\Login\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PortalLogin;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\RolesandPermission\RolesAndPermissionController;
use App\Http\Controllers\Useraccount\UserAccountController;
use App\Http\Controllers\Lecturer\LecturerHomeController;
use App\Http\Controllers\Lecturer\LecturerCourseController;
use App\Http\Controllers\Lecturer\LecturerAssignmentController;
use App\Http\Controllers\Lecturer\LecturerQuizzesController;
use App\Http\Controllers\Lecturer\LecturerExamsController;
use App\Http\Controllers\Student\StudentHomeController;
use App\Http\Controllers\Student\StudentCourseController;
use App\Http\Controllers\Student\StudentAssignmentController;
use App\Http\Controllers\Student\StudentAccountController;
use App\Http\Controllers\Student\StudentTimetableController;
use App\Http\Controllers\Student\StudentResultSlipController;
use App\Http\Controllers\Student\StudentContactController;
use App\Http\Controllers\Student\StudentFAQsController;
use App\Http\Controllers\Frontend\FrontendController;


use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminClassController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminAssignmentController;
use App\Http\Controllers\Admin\AdminQuizzesController;
use App\Http\Controllers\Admin\AdminExamsController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminLecturerController;
use App\Http\Controllers\Admin\AdminScoresController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminCoursePackagingController;
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
    Route::prefix('bio-data')->group(function () {
        Route::get('/get-regions/{district_id}', [BiodataController::class, 'getRegions'])->name('get-regions');
        Route::get('/get-branches', [BiodataController::class, 'getBranches'])->name('get.branches');
        Route::get('/get-courses', [BiodataController::class, 'getCourses'])->name('get.courses');
        Route::get('/', [BiodataController::class, 'biodata'])->name('bio-data');
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

Route::get('/admin/login', function () {
    return view('auth.login');
})->name('admin.login');
Auth::routes();
Route::post('/login', [AuthController::class, 'Login'])->name('login');
Route::get('/logout', [AuthController::class, 'Logout'])->name('logout');
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::get('/decrypt', [QrCodeController::class, 'decript'])->name('decrypt-applicant');
    Route::post('/qr-code', [QrCodeController::class, 'decryptQrCode'])->name('decrypt-qr-code');
    Route::group(['prefix' => 'reseult-verfication', 'as' => 'document.'], function () {
        Route::get('/', [DocumentationController::class, 'applicant_documentation'])->name('applicant-documentation');
        Route::get('/status/{uuid}', [DocumentationController::class, 'applicant_result_verified'])->name('documentation-status');
        Route::get('/edit/status/{uuid}', [DocumentationController::class, 'documentation_update'])->name('documentation-status-update');
        Route::post('/save-documentation/{uuid}', [DocumentationController::class, 'store_applicant_documentation'])->name('status-save-documentation');
        Route::post('/update-applicant-documentation/{uuid}', [DocumentationController::class, 'confirm_applicant_documentation'])->name('documentation-update');
        Route::get('/results-generation-report', [DocumentationController::class, 'master_filter_applicant_documentation'])->name('master-filter-documentation');
    });

    Route::group(['prefix' => 'applicant-preview', 'as' => 'correct.'], function () {
        Route::get('/{uuid}', [CorrectApplicantController::class, 'applicant_corrections'])->name('correction-applicant-data');
        Route::post('/applicant/corrections/{uuid}', [CorrectApplicantController::class, 'updateApplicantCorrections'])->name('applicant.corrections.update');
    });

    Route::group(['prefix' => 'body-selection-phase', 'as' => 'bodyselection.'], function () {
        Route::get('/', [BodySelectionController::class, 'applicant_bodyselection'])->name('applicant-body-selection');
        Route::get('/status/{uuid}', [BodySelectionController::class, 'applicant_bodyselection_status'])->name('body-selection-status');
        Route::get('/edit/body-selection/{uuid}', [BodySelectionController::class, 'bodyselection_update'])->name('body-selection-status-update');
        Route::post('/save-body-selection/{uuid}', [BodySelectionController::class, 'store_applicant_bodyselection'])->name('status-save-body-selection');
        Route::post('/update-applicant-body-selection/{uuid}', [BodySelectionController::class, 'confirm_applicant_bodyselection'])->name('body-selection-update');
        Route::get('/bodyselection-generate-report', [BodySelectionController::class, 'master_filter_applicant_bodyselection'])->name('master-filter-body-selection');
    });
    Route::group(['prefix' => 'aptitude-test-phase', 'as' => 'test.'], function () {
        Route::get('/', [AptitudeController::class, 'applicant_aptitude'])->name('applicant-aptitude-test');

        Route::post('/save-aptitude-test', [AptitudeController::class, 'store_applicant_aptitude'])->name('store-applicant-aptitude');

        Route::get('/status/{uuid}', [AptitudeController::class, 'applicant_aptitude_status'])->name('aptitude-test-status');
        Route::get('/edit/aptitude-test/{uuid}', [AptitudeController::class, 'aptitude_update'])->name('aptitude-test-status-update');
        Route::post('/save-aptitude-test/{uuid}', [AptitudeController::class, 'store_applicant_aptitude'])->name('status-save-aptitude-test');
        Route::post('/update-applicant-aptitude-test/{uuid}', [AptitudeController::class, 'confirm_applicant_aptitude'])->name('aptitude-test-update');
        Route::get('/aptitude-generate-report', [AptitudeController::class, 'master_filter_applicant_aptitude'])->name('master-filter-aptitude');
        Route::post('/import-aptitude', [AptitudeController::class, 'import'])->name('import.aptitude');
    });
    Route::group(['prefix' => 'baisc-fitness-phase', 'as' => 'fitnesstest.'], function () {
        Route::get('/', [BasicFitnessTestController::class, 'applicant_basicfitness'])->name('applicant-basicfitness');
        Route::get('/status/{uuid}', [BasicFitnessTestController::class, 'applicant_basicfitness_status'])->name('basicfitness-status');
        Route::get('/edit/basicfitness/{uuid}', [BasicFitnessTestController::class, 'basicfitness_update'])->name('basicfitness-status-update');
        Route::post('/save-basicfitness/{uuid}', [BasicFitnessTestController::class, 'store_applicant_basicfitness'])->name('status-save-basicfitness');
        Route::post('/update-applicant-basicfitness/{uuid}', [BasicFitnessTestController::class, 'confirm_applicant_basicfitness'])->name('basicfitness-update');
        Route::get('/basic-fitness-generate-report', [BasicFitnessTestController::class, 'master_filter_applicant_basicfitness'])->name('master-filter-basic-fitness');
    });

    Route::group(['prefix' => 'outdoor-leaderless-test', 'as' => 'test.'], function () {
        Route::get('/', [OutDoorLeaderlessTestController::class, 'applicant_outdoorlesstest'])->name('applicant-outdoorlesstest');
        Route::get('/status/{uuid}', [OutDoorLeaderlessTestController::class, 'applicant_outdoorlesstest_status'])->name('outdoorlesstest-status');
        Route::get('/edit/outdoorlesstest/{uuid}', [OutDoorLeaderlessTestController::class, 'outdoorleaderless_update'])->name('outdoorlesstest-status-update');
        Route::post('/save-outdoorlesstest/{uuid}', [OutDoorLeaderlessTestController::class, 'store_applicant_outdoorlesstest'])->name('status-save-outdoorlesstest');
        Route::post('/update-applicant-outdoorlesstest/{uuid}', [OutDoorLeaderlessTestController::class, 'confirm_applicant_outdoorlesstest'])->name('outdoorlesstest-update');
        Route::get('/outdoorleaderless-generate-report', [OutDoorLeaderlessTestController::class, 'master_filter_applicant_outdoorlesstest'])->name('master-filter-outdoor');
    });

    Route::group(['prefix' => 'medicals', 'as' => 'test.'], function () {
        Route::get('/', [MedicalsController::class, 'applicant_medicals'])->name('applicant-medical');
        Route::get('/status/{uuid}', [MedicalsController::class, 'applicant_medicals_status'])->name('medical-status');
        Route::get('/edit/medical/{uuid}', [MedicalsController::class, 'medicals_update'])->name('medical-status-update');
        Route::post('/save-medical/{uuid}', [MedicalsController::class, 'store_applicant_medicals'])->name('status-save-medical');
        Route::post('/update-applicant-medical/{uuid}', [MedicalsController::class, 'confirm_applicant_medicals'])->name('medical-update');
        Route::get('/medical-generate-report', [MedicalsController::class, 'master_filter_applicant_medicals'])->name('master-filter-medicals');
    });

    Route::group(['prefix' => 'vetting', 'as' => 'test.'], function () {
        Route::get('/', [VettingController::class, 'applicant_vetting'])->name('applicant-vetting');
        Route::get('/status/{uuid}', [VettingController::class, 'applicant_vetting_status'])->name('vetting-status');
        Route::get('/edit/vetting/{uuid}', [VettingController::class, 'vetting_update'])->name('vetting-status-update');
        Route::post('/save-vetting/{uuid}', [VettingController::class, 'store_applicant_vetting'])->name('status-save-vetting');
        Route::post('/update-applicant-vetting/{uuid}', [VettingController::class, 'confirm_applicant_vetting'])->name('vetting-update');
        Route::get('/vetting-generate-report', [VettingController::class, 'master_filter_applicant_vetting'])->name('master-filter-vetting');
    });

    Route::group(['prefix' => 'interview', 'as' => 'test.'], function () {
        Route::get('/', [InterviewController::class, 'applicant_interview'])->name('applicant-interview');
        Route::get('/status/{uuid}', [InterviewController::class, 'applicant_interview_status'])->name('interview-status');
        Route::get('/edit/interview/{uuid}', [InterviewController::class, 'interview_update'])->name('interview-status-update');
        Route::post('/save-interview/{uuid}', [InterviewController::class, 'store_applicant_interview'])->name('status-save-interview');
        Route::post('/update-applicant-interview/{uuid}', [InterviewController::class, 'confirm_applicant_interview'])->name('interview-update');
        Route::get('/interview-generate-report', [InterviewController::class, 'master_filter_applicant_interview'])->name('master-filter-interview');

        Route::post('/pass-applicants-for-admission', [InterviewController::class, 'Interview_Qualified'])->name('pass-applicants-for-admission');
        Route::post('/disqualify-applicants', [InterviewController::class, 'Interview_Disqualified'])->name('disqualify-applicants');
    });

    Route::prefix('regions')->group(function () {
        Route::get('/', [RegionController::class, 'View'])->name('view-index');
        Route::get('/add', [RegionController::class, 'AddCate'])->name('create');
        Route::post('/store', [RegionController::class, 'Store'])->name('store-region');
        Route::get('/edit/{uuid}', [RegionController::class, 'Edit'])->name('edit-region');
        Route::post('/update', [RegionController::class, 'Update'])->name('update-region');
        Route::get('/{uuid}', [RegionController::class, 'Delete'])->name('delete-region');
    });

    Route::prefix('region-districts')->group(function () {
        Route::get('/', [DistrictController::class, 'View'])->name('view-districts');
        Route::get('/mech', [DistrictController::class, 'Add'])->name('mech-districts');
        Route::post('/store', [DistrictController::class, 'Store'])->name('store-districts');
        Route::get('/edit/{uuid}', [DistrictController::class, 'Edit'])->name('edit-districts');
        Route::post('/update{uuid}', [DistrictController::class, 'Update'])->name('update-districts');
        Route::get('/delete{uuid}', [DistrictController::class, 'Delete'])->name('delete-districts');
        Route::post('/view-districts', [DistrictController::class, 'index'])->name('view-region-district');
    });
    Route::group(['prefix' => 'bece-results', 'as' => 'results.'], function () {
        Route::get('/', [BeceResultController::class, 'view'])->name('bece-results-index');
        Route::get('/mech', [BeceResultController::class, 'Add'])->name('mech-bece-results');
        Route::post('/store', [BeceResultController::class, 'Store'])->name('store-bece-results');
        Route::get('/edit/{uuid}', [BeceResultController::class, 'Edit'])->name('edit-bece-results');
        Route::post('/update{uuid}', [BeceResultController::class, 'Update'])->name('update-bece-results');
        Route::get('/delete{uuid}', [BeceResultController::class, 'Delete'])->name('delete-bece-results');
        Route::post('/view-bece-results', [BeceResultController::class, 'index'])->name('view-bece-results');
    });
    Route::group(['prefix' => 'wassce-results', 'as' => 'results.'], function () {
        Route::get('/', [WassceResultController::class, 'view'])->name('wassce-results-index');
        Route::get('/mech', [WassceResultController::class, 'Add'])->name('mech-wassce-results');
        Route::post('/store', [WassceResultController::class, 'Store'])->name('store-wassce-results');
        Route::get('/edit/{uuid}', [WassceResultController::class, 'Edit'])->name('edit-wassce-results');
        Route::post('/update{uuid}', [WassceResultController::class, 'Update'])->name('update-wassce-results');
        Route::get('/delete{uuid}', [WassceResultController::class, 'Delete'])->name('delete-wassce-results');
        Route::post('/view-wassce-results', [WassceResultController::class, 'index'])->name('view-wassce-results');
    });

    Route::group(['prefix' => 'bece-subjects', 'as' => 'subject.'], function () {
        Route::get('/', [BeceSubjectController::class, 'view'])->name('bece-subject-index');
        Route::get('/mech', [BeceSubjectController::class, 'Add'])->name('mech-bece-subject');
        Route::post('/store', [BeceSubjectController::class, 'Store'])->name('store-bece-subject');
        Route::get('/edit/{uuid}', [BeceSubjectController::class, 'Edit'])->name('edit-bece-subject');
        Route::post('/update{uuid}', [BeceSubjectController::class, 'Update'])->name('update-bece-subject');
        Route::get('/delete{uuid}', [BeceSubjectController::class, 'Delete'])->name('delete-bece-subject');
        Route::post('/view-bece-subject', [BeceSubjectController::class, 'index'])->name('view-bece-subject');
    });
    Route::group(['prefix' => 'wassce-subjects', 'as' => 'subject.'], function () {
        Route::get('/', [WassceSubjectController::class, 'view'])->name('wassce-subject-index');
        Route::get('/mech', [WassceSubjectController::class, 'Add'])->name('mech-wassce-subject');
        Route::post('/store', [WassceSubjectController::class, 'Store'])->name('store-wassce-subject');
        Route::get('/edit/{uuid}', [WassceSubjectController::class, 'Edit'])->name('edit-wassce-subject');
        Route::post('/update{uuid}', [WassceSubjectController::class, 'Update'])->name('update-wassce-subject');
        Route::get('/delete{uuid}', [WassceSubjectController::class, 'Delete'])->name('delete-wassce-subject');
        Route::post('/view-wassce-subject', [WassceSubjectController::class, 'index'])->name('view-wassce-subject');
    });

    Route::group(['prefix' => 'offering-courses', 'as' => 'arm.'], function () {
        Route::get('/', [OfferingCourseController::class, 'index'])->name('arm-of-service');
        Route::get('/mech', [OfferingCourseController::class, 'Add'])->name('mech-arm-of_service');
        Route::post('/store', [OfferingCourseController::class, 'Store'])->name('store-arm-of_service');
        Route::get('/edit/{uuid}', [OfferingCourseController::class, 'Edit'])->name('edit-arm-of_service');
        Route::post('/update{uuid}', [OfferingCourseController::class, 'Update'])->name('update-arm-of_service');
        Route::get('/delete{uuid}', [OfferingCourseController::class, 'Delete'])->name('delete-arm-of_service');
        Route::post('/view-arm-of_service', [OfferingCourseController::class, 'index'])->name('view-arm-of_service');
    });

    Route::group(['prefix' => 'reports', 'as' => 'report.'], function () {
        Route::get('/', [ReportGenerationController::class, 'reports'])->name('report-generation');
        Route::get('/applicant/{uuid}', [ReportGenerationController::class, 'applicant_pdf'])->name('admin-applicant-pdf');
        Route::get('phases/applicant/{uuid}', [ReportGenerationController::class, 'showApplicantPhases'])->name('applicant.view');
        Route::get('/delete/applicant/{uuid}', [ReportGenerationController::class, 'deleteApplicant'])->name('delete-applicant');
        // Admin Preview
        Route::get('/applicant-preview', [ReportGenerationController::class, 'applicant_preview_data'])->name('correct-applicant-data');
    });

    Route::group(['prefix' => 'commission-type', 'as' => 'commissin.'], function () {
        Route::get('/', [CommissionTypeController::class, 'index'])->name('commission-type');
        Route::get('/mech', [CommissionTypeController::class, 'Add'])->name('mech-commission-type');
        Route::post('/store', [CommissionTypeController::class, 'Store'])->name('store-commission-type');
        Route::get('/edit/{uuid}', [CommissionTypeController::class, 'Edit'])->name('edit-commission-type');
        Route::post('/update{uuid}', [CommissionTypeController::class, 'Update'])->name('update-commission-type');
        Route::get('/delete{uuid}', [CommissionTypeController::class, 'Delete'])->name('delete-commission-type');
        Route::post('/view-commission-type', [CommissionTypeController::class, 'index'])->name('view-commission-type');
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

    Route::group(['prefix' => 'branches', 'as' => 'bran.'], function () {
        Route::get('/', [BranchController::class, 'View'])->name('branch-index');
        Route::get('/mech', [BranchController::class, 'Add'])->name('mech-branch');
        Route::post('/store', [BranchController::class, 'Store'])->name('store-branch');
        Route::get('/edit/{uuid}', [BranchController::class, 'Edit'])->name('edit-branch');
        Route::post('/update{uuid}', [BranchController::class, 'Update'])->name('update-branch');
        Route::get('/delete{uuid}', [BranchController::class, 'Delete'])->name('delete-branch');
        Route::post('/view-branch', [BranchController::class, 'index'])->name('view-branch');
    });
    Route::group(['prefix' => 'agelimit', 'as' => 'set.'], function () {
        Route::get('/', [AgeLimitController::class, 'index'])->name('agelimit-index');
        Route::get('/mech', [AgeLimitController::class, 'Add'])->name('mech-agelimit');
        Route::post('/store', [AgeLimitController::class, 'Store'])->name('store-agelimit');
        Route::get('/edit/{uuid}', [AgeLimitController::class, 'Edit'])->name('edit-agelimit');
        Route::post('/update{uuid}', [AgeLimitController::class, 'Update'])->name('update-agelimit');
        Route::get('/delete{uuid}', [AgeLimitController::class, 'Delete'])->name('delete-agelimit');
        Route::post('/view-agelimit', [AgeLimitController::class, 'index'])->name('view-agelimit');
    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [RolesAndPermissionController::class, 'index'])->name('index-roles');
        Route::get('/add', [RolesAndPermissionController::class, 'create'])->name('create-roles');
        Route::post('/store', [RolesAndPermissionController::class, 'store'])->name('store-roles');
        Route::get('/edit/{uuid}', [RolesAndPermissionController::class, 'edit'])->name('edit-roles');
        Route::post('/update', [RolesAndPermissionController::class, 'update'])->name('update-roles');
        Route::get('/delete{uuid}', [RolesAndPermissionController::class, 'destroy'])->name('destroy-roles');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', [UserAccountController::class, 'index'])->name('index-user');
        Route::get('/add', [UserAccountController::class, 'create'])->name('create-user');
        Route::post('/store', [UserAccountController::class, 'store'])->name('store-user');
        Route::get('/edit/{uuid}', [UserAccountController::class, 'edit'])->name('edit-user');
        Route::post('/update', [UserAccountController::class, 'update'])->name('update-user');
        Route::get('/delete{uuid}', [UserAccountController::class, 'destroy'])->name('destroy-user');
    });

    Route::prefix('Profile')->group(function () {
        Route::get('/', [ProfileController::class, 'ProfileView'])->name('profile.index');
        Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');
        Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');
        Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');
        Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');
        Route::get('/inactivation{uuid}', [ProfileController::class, 'Inactive'])->name('user.inactive');
        Route::get('/activation{uuid}', [ProfileController::class, 'Active'])->name('user.active');
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

//Admin Routes
//Route::prefix('admin')->group(function () {
    Route::prefix('admin')->middleware(['auth'])->group(function () {
        //Admin HomePage Route
        Route::get('/dashboard', [AdminHomeController::class, 'dashboard'])->name('admin.dashboard');

        //Admin Courses Routes
        Route::get('/courses', [AdminCourseController::class, 'courses'])->name('admin.courses');
        Route::post('/course/add', [AdminCourseController::class, 'course_add'])->name('admin.course.add');
        Route::delete('course/delete/{id}', [AdminCourseController::class, 'destroy'])->name('admin.course.delete');


        //Admin Category Routes
        Route::get('/category', [AdminCategoryController::class, 'category'])->name('admin.category');
        Route::post('/category/add', [AdminCategoryController::class, 'category_add'])->name('admin.category.add');
        Route::delete('category/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.category.delete');


        //Admin Subject Routes
        Route::get('/subjects', [AdminSubjectController::class, 'subjects'])->name('admin.subjects');
        Route::post('/subject/add', [AdminSubjectController::class, 'subject_add'])->name('admin.subject.add');
        Route::delete('subject/delete/{id}', [AdminSubjectController::class, 'destroy'])->name('admin.subject.delete');
        Route::get('/subject/material', [AdminSubjectController::class, 'subject_material'])->name('admin.subject.material');
        Route::post('/materials/store', [AdminSubjectController::class, 'material_store'])->name('admin.materials.store');
        Route::delete('/material/delete/{id}', [AdminSubjectController::class, 'material_destroy'])->name('admin.materials.destroy');
        Route::get('/subject/allocation', [AdminSubjectController::class, 'subject_allocation'])->name('admin.subject.allocation');
        Route::post('/allocation/store', [AdminSubjectController::class, 'allocation_store'])->name('admin.allocation.store');
        Route::delete('/allocation/delete/{id}', [AdminSubjectController::class, 'destroy_allocation'])->name('admin.allocation.delete');

        //Admin Courses Routes
        // Route::get('/courses', [AdminCourseController::class, 'courses'])->name('admin.courses');
        // Route::get('/materials', [AdminCourseController::class, 'materials'])->name('admin.materials');
        // Route::get('/courses/allocation', [AdminCourseController::class, 'courses_allocation'])->name('admin.courses.allocation');

        //Assignments
        Route::get('/assignments', [AdminAssignmentController::class, 'assignments'])->name('admin.assignments');
        Route::get('/assignments/marks', [AdminAssignmentController::class, 'assignment_marks'])->name('admin.assignments.marks');
        Route::post('/assignment/store', [AdminAssignmentController::class, 'assignment_store'])->name('admin.assignment.store');
        Route::delete('/assignment/delete/{id}', [AdminAssignmentController::class, 'assignment_destroy'])->name('admin.assignment.delete');

        //Score
        Route::get('/score', [AdminScoresController::class, 'scores'])->name('admin.scores');

        //Users
        Route::get('/users', [AdminUsersController::class, 'users'])->name('admin.users');
        Route::post('/users/store', [AdminUsersController::class, 'store'])->name('admin.users.add');
        Route::delete('/users/delete/{id}', [AdminUsersController::class, 'destroy_users'])->name('admin.users.delete');

        //allocation
        Route::get('/user/course/allocation', [AdminUsersController::class, 'user_course_allocation'])->name('admin.user.course.allocation');
        Route::get('/fetch-users', [AdminUsersController::class, 'fetch_users']);
        Route::post('/users/courses/store', [AdminUsersController::class, 'users_courses_store'])->name('admin.user.course.add');
        Route::delete('/user-course-allocation/delete/{id}', [AdminUsersController::class, 'user_course_allocation_destroy'])->name('admin.users.course.allocation.delete');
        Route::get('/fetch-students', [AdminUsersController::class, 'fetchStudents'])->name('fetch.students');

        //Course Packaging
        Route::get('/course-packaging', [AdminCoursePackagingController::class, 'course_packaging'])->name('admin.course.packaging');
        Route::post('/add-course-packaging', [AdminCoursePackagingController::class, 'add_course_packaging'])->name('admin.add.course.package');
        Route::delete('/course-packaging/delete/{id}', [AdminCoursePackagingController::class, 'destroy'])->name('admin.course.package.delete');


        //Quizzes
        // Route::get('/quizzes', [AdminQuizzesController::class, 'quizzes'])->name('admin.quizzes');

        //Exams
        // Route::get('/exams',[AdminExamsController::class, 'exams'])->name('admin.exams');

        //Reports
        Route::get('/report/courses', [AdminCourseController::class, 'report_courses'])->name('admin.report.courses');
        Route::get('/report/assignments', [AdminAssignmentController::class, 'report_assignments'])->name('admin.report.assignments');
        Route::get('/report/performance', [AdminAssignmentController::class, 'report_performance'])->name('admin.report.performance');

        Route::get('/guide', [AdminAssignmentController::class, 'guide'])->name('admin.guide');





        //Admin Students
        // Route::get('/students', [AdminStudentController::class, 'students'])->name('admin.students');


        //Admin Lecturers
        // Route::get('/lecturers', [AdminLecturerController::class, 'lecturers'])->name('admin.lecturers');

    });




    //Lecturers Route
    //Route::prefix('lecturer')->group(function () {
    Route::prefix('lecturer')->middleware(['auth'])->group(function () {

        //Lecturer Homepage Route
        Route::get('/dashboard', [LecturerHomeController::class, 'dashboard'])->name('lecturer.dashboard');

        //Lecturer Course Route
        Route::get('/materials', [LecturerCourseController::class, 'materials'])->name('lecturer.course.material');

        //Lecturer Assignments
        Route::get('/assignments', [LecturerAssignmentController::class, 'assignments'])->name('lecturer.assignments');

        //Assignments Marks
        Route::get('/assignments/marks', [LecturerAssignmentController::class, 'assignment_marks'])->name('lecturer.assignments.marks');

        //Quizzes Marks
        Route::get('/quizzes', [lecturerQuizzesController::class, 'quizzes'])->name('lecturer.quizzes');

        //Exams mark
        Route::get('/exams',[LecturerExamsController::class, 'exams'])->name('lecturer.exams');

        //Report
        Route::get('/report/courses', [LecturerCourseController::class, 'report_courses'])->name('lecturer.report.courses');
        Route::get('/report/assignments', [LecturerAssignmentController::class, 'report_assignments'])->name('lecturer.report.assignments');
        Route::get('/report/performance', [LecturerAssignmentController::class, 'report_performance'])->name('lecturer.report.performance');


    });



    //Students Route
    //Route::prefix('student')->group(function () {
    Route::prefix('student')->middleware(['auth'])->group(function () {

        //Student Home
        Route::get('/dashboard', [StudentHomeController::class, 'dashboard'])->name('student.dashboard');

        //Admission
        Route::get('/account', [StudentAccountController::class, 'account'])->name('student.account');

        //Time Table
        Route::get('/time-table', [StudentTimetableController::class, 'time_table'])->name('student.time.table');

        //Results Slip
        Route::get('/student-slip', [StudentResultSlipController::class, 'result_slip'])->name('student.result.slip');


        //Student Courses
        Route::get('/courses', [StudentCourseController::class, 'courses'])->name('student.courses');
        Route::post('/register-courses', [StudentCourseController::class, 'register_courses'])->name('student.courses.register');


        //Student Assignments
        Route::get('/assignments', [StudentAssignmentController::class, 'assignments'])->name('student.assignments');

        //Student Performance
        Route::get('/performance', [StudentAssignmentController::class, 'performance'])->name('student.performance');

        //Student Contact
        Route::get('/contact', [StudentContactController::class, 'contact'])->name('student.contact');

        //Student FAQs
        Route::get('/faqs', [StudentFAQsController::class, 'faqs'])->name('student.faqs');


    });
