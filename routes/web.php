<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaranggayAdminController;
use App\Http\Controllers\BirthdayCashGiftBarangayController;
use App\Http\Controllers\BirthdayCashGiftsController;
use App\Http\Controllers\BirthdayCashGiftsFieldworker;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FieldWorkerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    /* Authenctiocation Section */
    Route::get('/', function () {
        return view('welcome');
    });
    Route::get('/super-admin/login', [AuthController::class, 'superAdminLoginView']);
    Route::get('/baranggay-admin/login', [AuthController::class, 'baranggayAdminLoginView']);
    Route::get('/field-worker/login', [AuthController::class, 'fieldWorkerLoginView']);

    Route::post('/super-admin/auth/login', [AuthController::class, 'verifySuperAdmin']);
    Route::post('/baranggay-admin/auth/login', [AuthController::class, 'verifyBaranggayAdmin']);
    Route::post('/fieldworker/auth/login', [AuthController::class, 'verifyFieldWorker']);
});



/* Super Admin Section */
Route::middleware(['auth', RoleMiddleware::class . ':Super Admin'])->group(function () {
    Route::get('/super-admin/dashboard', [SuperAdminController::class, 'dashboardView'])->name('dashboard');
    Route::get('/super-admin/dashboard/create-baranggay', [SuperAdminController::class, 'createBaranggayView']);
    Route::get('/super-admin/dashboard/baranggay/{baranggay}/edit', [SuperAdminController::class, 'editBaranggayView']);
    Route::get('/super-admin/dashboard/baranggay/{baranggay}/report', [SuperAdminController::class, 'viewBaranggayReport'])->name('baranggay-report');
    Route::get('/administrator/change-password/{user}', [SuperAdminController::class, 'changePasswordView']);
    Route::patch('/administrator/change-password/{user}', [SuperAdminController::class, 'changePassword']);

    Route::delete('/super-admin/dashboard/baranggay/{baranggay}/delete', [SuperAdminController::class, 'deleteBaranggay']);
    Route::delete('/super-admin/dashboard/accounts/{user}/delete', [SuperAdminController::class, 'deleteAdministrator']);

    Route::get('/super-admin/dashboard/baranggay/add-pwd', [SuperAdminController::class, 'addPWDView']);
    Route::get('/super-admin/dashboard/baranggay/pwd/{personWithDisability}/view', [SuperAdminController::class, 'viewPWDInfo']);
    Route::get('/super-admin/dashboard/baranggay/pwd/{personWithDisability}/edit', [SuperAdminController::class, 'editPWDInfo']);
    Route::delete('/super-admin/dashboard/baranggay/pwd/{personWithDisability}/delete', [SuperAdminController::class, 'deletePWD']);

    Route::patch('/super-admin/dashboard/edit-pwd/{personWithDisability}/update', [SuperAdminController::class, 'storeUpdatedPWDInfo']);
    Route::patch('/super-admin/dashboard/baranggay/{baranggay}/update', [SuperAdminController::class, 'updatedBaranggay']);

    Route::post('/super-admin/dashboard/add-pwd/create', [SuperAdminController::class, 'storePWDInfo']);
    Route::post('/super-admin/dashboard/create-baranggay/create', [SuperAdminController::class, 'storeBaranggay']);

    Route::get('/super-admin/dashboard/accounts', [SuperAdminController::class, 'accountDashboard'])->name('account-dashboard');
    Route::get('/super-admin/dashboard/accounts/create-account', [SuperAdminController::class, 'createAccountView']);

    Route::get('/super-admin/dashboard/accounts/{baranggay}/view-census-data', [SuperAdminController::class, 'viewCensusData'])->name('view-census');

    Route::get('/super-admin/dashboard/accounts/{user}/edit', [SuperAdminController::class, 'updateAccountView']);

    Route::post('/super-admin/dashboard/accounts/create-account/create', [SuperAdminController::class, 'storeAccount']);
    Route::patch('/super-admin/dashboard/accounts/{user}/update', [SuperAdminController::class, 'storeUpdatedAccount']);

    Route::get('/super-admin/dashboard/events-programs', [EventController::class, 'index'])->name('event-dashboard');
    Route::get('/super-admin/dashboard/events-programs/create-event', [EventController::class, 'addEventView']);
    Route::get('/super-admin/dashboard/events-programs/{event}/program', [EventController::class, 'viewProgram']);
    Route::get('/super-admin/dashboard/events-programs/{event}/program/edit', [EventController::class, 'editProgram']);
    Route::get('/super-admin/dashboard/events-programs/{event}/program-report', [EventController::class, 'programReportView']);
    Route::get('/super-admin/dashboard/events-programs/send-invitation/sent', [EventController::class, 'sendingInvitation'])->name('invitation-sent');
    
    Route::get('/super-admin/dashboard/events-programs/{personWithDisability}/contact/{event}', [EventController::class, 'contactPersonView']);

    Route::post('/super-admin/dashboard/events-programs/send-invitation', [EventController::class, 'sendProgramInvitation'])->name('send-invitation');
    Route::post('/super-admin/dashboard/events-programs/invitation', [EventController::class, 'programInvitation'])->name('program-invitation');
    Route::post('/super-admin/dashboard/events-programs/create-event/store', [EventController::class, 'storeEvent']);
    Route::post('/super-admin/dashboard/events-programs/attendance/add', [EventController::class, 'storeAttendance']);

    Route::patch('/super-admin/dashboard/events-programs/{event}/program/update', [EventController::class, 'storeUpdatedProgram']);

    Route::get('/super-admin/dashboard/events-programs/birthday-cash-gifts', [BirthdayCashGiftsController::class, 'index'])->name('cashGifts.super-admin');
    Route::get('/super-admin/dashboard/events-programs/birthday-cash-gifts/baranggay/{baranggay}', [BirthdayCashGiftsController::class, 'birthdayWithinBarangay'])->name('cashGifts.barangay.super-admin');
    Route::get('/super-admin/dashboard/events-programs/birthday-cash-gifts/baranggay/{baranggay}/status/{personWithDisability}', [BirthdayCashGiftsController::class, 'updateStatusForm'])->name('cashGifts.updateForm.super-admin');

    Route::patch('/super-admin/birhtday-cash-gift/update-status/{personWithDisability}', [BirthdayCashGiftsController::class,'storeStatus'])->name('cashGifts.updateForm.store.super-admin');

});

/* Barangagy Admin Section */
Route::middleware(['auth', RoleMiddleware::class . ':Baranggay Admin'])->group(function () {
    Route::get('/baranggay-admin/residents-reports', [BaranggayAdminController::class, 'index'])->name('baranggay-dashboard');
    Route::get('/baranggay-admin/events-programs', [BaranggayAdminController::class, 'eventsAndPrograms']);

    Route::get('/baranggay-admin/residents-reports/pwd/create', [BaranggayAdminController::class, 'createPWD']);
    Route::get('/baranggay-admin/residents-reports/{personWithDisability}/view', [BaranggayAdminController::class, 'viewPWD']);
    Route::get('/baranggay-admin/residents-reports/{personWithDisability}/edit', [BaranggayAdminController::class, 'editPWDView']);

    Route::get('/baranggay-admin/events-programs/event/create', [BaranggayAdminController::class, 'viewAddEvent']);
    Route::get('/baranggay-admin/events-programs/event/{event}/view', [BaranggayAdminController::class, 'viewProgram']);
    Route::get('/baranggay-admin/events-programs/event/{event}/edit', [BaranggayAdminController::class, 'editEvent']);
    Route::get('/baranggay-admin/events-programs/event/{event}/report', [BaranggayAdminController::class, 'viewProgramReport']);

    Route::post('/baranggay-admin/events-programs/event/invitation', [BaranggayAdminController::class, 'viewProgramInvitation']);
    Route::post('/baranggay-admin/events-programs/event/invitation/sending', [BaranggayAdminController::class, 'sendProgramInvitation']);
    Route::get('/baranggay-admin/events-programs/event/invitation/sent', [BaranggayAdminController::class, 'sendingInvitation']);

    Route::post('/event/store', [BaranggayAdminController::class, 'storeEvent']);
    Route::post('/event/attendance/add', [BaranggayAdminController::class, 'addAttendance']);
    Route::post('/pwd/store', [BaranggayAdminController::class, 'storePWD']);

    Route::patch('/pwd/updated-info/{personWithDisability}', [BaranggayAdminController::class, 'storeUpdatedPWD']);
    Route::patch('/event/update/{event}', [BaranggayAdminController::class, 'storeUpdatedEvent']);
    Route::delete('/pwd/delete/{personWithDisability}', [BaranggayAdminController::class, 'deletePWD']);

    Route::get('/baranggay-admin/events-programs/birthday-cash-gifts', [BirthdayCashGiftBarangayController::class, 'index'])->name('cashGifts.barangay');
    Route::get('/baranggay-admin/events-programs/birthday-cash-gifts/baranggay/status/{personWithDisability}', [BirthdayCashGiftBarangayController::class, 'updateStatusForm'])->name('cashGifts.updateForm');

    Route::patch('/baranggay-admin/birhtday-cash-gift/update-status/{personWithDisability}', [BirthdayCashGiftBarangayController::class,'storeStatus'])->name('cashGifts.updateForm.store');
});

/* Field Worker Section */
Route::middleware(['auth', RoleMiddleware::class . ':Field Worker'])->group(function () {
    Route::get('/fieldworker/register-residents', [FieldWorkerController::class, 'index'])->name('fieldworker-dashboard');
    Route::get('/fieldworker/register-residents/pwd/create', [FieldWorkerController::class, 'createPWD']);
    Route::get('/fieldworker/register-residents/{personWithDisability}/edit', [FieldWorkerController::class, 'editPWDView']);

    Route::get('/fieldworker/events-programs', [FieldWorkerController::class, 'eventsAndPrograms']);
    Route::get('/fieldworker/events-programs/event/create', [FieldWorkerController::class, 'addEventView']);
    Route::get('/fieldworker/events-programs/{event}/view', [FieldWorkerController::class, 'viewProgram']);
    Route::get('/fieldworker/events-programs/{event}/edit', [FieldWorkerController::class, 'editProgram']);
    Route::get('/fieldworker/events-programs/{event}/program-report', [FieldWorkerController::class, 'programReportView']);

    Route::post('/fieldworker/events-programs/program/invitation', [FieldWorkerController::class, 'programInvitation']);
    Route::post('/fieldworker/events-programs/program/invitation/sending', [FieldWorkerController::class, 'sendProgramInvitation']);
    Route::get('/fieldworker/events-programs/program/invitation/sent', [FieldWorkerController::class, 'sendingInvitation']);

    Route::post('/field-worker/pwd/create/store', [FieldWorkerController::class, 'storePWD']);
    Route::post('/field-worker/attendance/store', [FieldWorkerController::class, 'storeAttendance']);
    Route::post('/field-worker/event/store', [FieldWorkerController::class, 'storeEvent']);
    Route::patch('/field-worker/pwd/update/{personWithDisability}', [FieldWorkerController::class, 'storeUpdatedPWD']);
    Route::patch('/field-worker/event/update/{event}', [FieldWorkerController::class, 'storeUpdatedEvent']);
    Route::delete('/fieldworker/register-residents/{personWithDisability}/delete', [FieldWorkerController::class, 'deletePWD']);

    
    Route::get('/fieldworker/events-programs/birthday-cash-gifts', [BirthdayCashGiftsFieldworker::class, 'index'])->name('cashGifts');
    Route::get('/fieldworker/events-programs/birthday-cash-gifts/baranggay/status/{personWithDisability}', [BirthdayCashGiftsFieldworker::class, 'updateStatusForm'])->name('cashGifts.updateForm');

    Route::patch('/fieldworker/birhtday-cash-gift/update-status/{personWithDisability}', [BirthdayCashGiftsFieldworker::class,'storeStatus'])->name('cashGifts.updateForm.store');

});

Route::middleware(['auth'])->group(function () {

    Route::post('/program/cancelled', [EventController::class, 'cancelledProgram'])->name('cancel-program');
    Route::post('/conctact/send-sms', [EventController::class, 'sendSMS'])->name('sendSMS');

    Route::get('/event/notification', [NotificationController::class, 'index']);

    Route::get('/pwd-data/pdf/{personWithDisability}', [PDFController::class, 'personWithDisabilityData'])->name('generate-pwd-data');
    Route::get('/baranggay-report/pdf', [PDFController::class, 'baranggayReport'])->name('generate-baranggay-report');
    Route::get('/specific-barangay-report/pdf/{baranggay}', [PDFController::class, 'specificBaranggayReport']);
    Route::get('/people-list-within-baranggay/pdf/{baranggay}', [PDFController::class, 'personWithinBaranggay']);
    Route::get('/people-list-within-baranggay-with-disability/pdf/{baranggay}', [PDFController::class, 'personWithinBaranggayWithDisability']);
    Route::get('/program/pdf/{event}', [PDFController::class, 'programEvent']);
    Route::get('/program/report/{event}', [PDFController::class, 'programReport']);

    Route::post('/auth/logout', [AuthController::class, 'logoutUser']);
});
