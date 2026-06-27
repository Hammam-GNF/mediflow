<?php

use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\FinancialReportController;
use App\Http\Controllers\Admin\InvoiceItemController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\MedicalRecordReportController;
use App\Http\Controllers\Admin\MedicationController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PatientReportController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PolyclinicController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\ReceiptController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\RegistrationReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\ExaminationController;
use App\Http\Controllers\Doctor\Icd10Controller;
use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\ProfileController;
use App\Services\Satusehat\SatusehatAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    /** @var \App\Models\User|null $user */
    $user = Auth::user();

    if ($user) {

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('doctor')) {
            return redirect()->route('doctor.dashboard');
        }
    }

    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::get('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::put('users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.update-password');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

    Route::get('users-export', [UserController::class, 'export'])->name('users.export');

    Route::get('users-trash', [UserController::class, 'trash'])->name('users.trash');
    Route::put('users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{user}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');

    Route::resource('polyclinics', PolyclinicController::class);
    Route::get('polyclinics-trash', [PolyclinicController::class, 'trash'])->name('polyclinics.trash');
    Route::put('polyclinics/{polyclinic}/restore', [PolyclinicController::class, 'restore'])->name('polyclinics.restore');
    Route::delete('polyclinics/{polyclinic}/force-delete', [PolyclinicController::class, 'forceDelete'])->name('polyclinics.force-delete');

    Route::resource('doctors', DoctorController::class);
    Route::get('doctors-trash', [DoctorController::class, 'trash'])->name('doctors.trash');
    Route::put('doctors/{doctor}/restore', [DoctorController::class, 'restore'])->name('doctors.restore');
    Route::delete('doctors/{doctor}/force-delete', [DoctorController::class, 'forceDelete'])->name('doctors.force-delete');

    Route::resource('patients', PatientController::class);
    Route::get('patients-trash', [PatientController::class, 'trash'])->name('patients.trash');
    Route::put('patients/{patient}/restore', [PatientController::class, 'restore'])->name('patients.restore');
    Route::delete('patients/{patient}/force-delete', [PatientController::class, 'forceDelete'])->name('patients.force-delete');

    Route::resource('registrations', RegistrationController::class);
    Route::get('registrations-trash', [RegistrationController::class, 'trash'])->name('registrations.trash');
    Route::put('registrations/{registration}/restore', [RegistrationController::class, 'restore'])->name('registrations.restore');
    Route::delete('registrations/{registration}/force-delete', [RegistrationController::class, 'forceDelete'])->name('registrations.force-delete');

    Route::resource('queues', QueueController::class)->except(['create', 'store']);
    Route::get('queues-trash', [QueueController::class, 'trash'])->name('queues.trash');
    Route::put('queues/{queue}/restore', [QueueController::class, 'restore'])->name('queues.restore');
    Route::delete('queues/{queue}/force-delete', [QueueController::class, 'forceDelete'])->name('queues.force-delete');
    Route::patch('queues/{queue}/call', [QueueController::class, 'call'])->name('queues.call');
    Route::patch('queues/{queue}/cancel', [QueueController::class, 'cancel'])->name('queues.cancel');

    Route::resource('invoices',InvoiceController::class)->only(['index','show']);
    Route::patch('invoices/{invoice}/cancel',[InvoiceController::class, 'cancel'])->name('invoices.cancel');

    Route::post('invoices/{invoice}/items',[InvoiceItemController::class, 'store'])->name('invoice-items.store');
    Route::delete('invoice-items/{invoiceItem}',[InvoiceItemController::class, 'destroy'])->name('invoice-items.destroy');

    Route::get('invoices/{invoice}/payment',[PaymentController::class, 'create'])->name('payments.create');
    Route::post('invoices/{invoice}/payment',[PaymentController::class, 'store'])->name('payments.store');

    Route::get('receipts/{invoice}',[ReceiptController::class, 'show'])->name('receipts.show');
    Route::get('receipts/{invoice}/pdf',[ReceiptController::class, 'pdf'])->name('receipts.pdf');

    Route::get('reports/financial',[FinancialReportController::class, 'index'])->name('reports.financial');
    Route::get('reports/financial/pdf',[FinancialReportController::class, 'pdf'])->name('reports.financial.pdf');

    Route::get('reports/registrations',[RegistrationReportController::class, 'index'])->name('reports.registrations');
    Route::get('reports/registrations/pdf',[RegistrationReportController::class, 'pdf'])->name('reports.registrations.pdf');

    Route::get('reports/patients',[PatientReportController::class, 'index'])->name('reports.patients');
    Route::get('reports/patients/pdf',[PatientReportController::class, 'pdf'])->name('reports.patients.pdf');

    Route::get('reports/medical-records',[MedicalRecordReportController::class, 'index'])->name('reports.medical-records');
    Route::get('reports/medical-records/pdf',[MedicalRecordReportController::class, 'pdf'])->name('reports.medical-records.pdf');

    Route::get('medications/{medication}/adjust-stock',[MedicationController::class, 'adjustStock'])->name('medications.adjust-stock');
    Route::post('medications/{medication}/adjust-stock',[MedicationController::class, 'storeAdjustment'])->name('medications.store-adjustment');
    Route::get('medications/{medication}/stock-history',[MedicationController::class, 'stockHistory'])->name('medications.stock-history');

    Route::resource('medications',MedicationController::class);

    Route::post('patients/{patient}/sync-satusehat',[PatientController::class, 'sync'])->name('patients.sync-satusehat');
    Route::post('/doctors/{doctor}/sync-satusehat',[DoctorController::class, 'sync'])->name('doctors.sync-satusehat');

    Route::post('settings/validate-organization',[SettingController::class, 'validateOrganization'])->name('settings.validate-organization');
    
    Route::get('/test-satusehat', function (
    \App\Services\Satusehat\SatusehatService $satusehat
    ) {
        return $satusehat->get('/metadata')->body();
    });

});

Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('examinations',[ExaminationController::class, 'index'])->name('examinations.index');
    Route::get('examinations/{queue}/create',[ExaminationController::class, 'create'])->name('examinations.create');
    Route::patch('examinations/{queue}/start',[ExaminationController::class, 'start'])->name('examinations.start');
    Route::post('examinations/{queue}',[ExaminationController::class, 'store'])->name('examinations.store');

    Route::get('medical-records',[MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('medical-records/{medicalRecord}',[MedicalRecordController::class, 'show'])->name('medical-records.show');

    Route::get('icd10/search',[Icd10Controller::class, 'search'])->name('icd10.search');


});

require __DIR__.'/auth.php';
