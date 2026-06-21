<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PolyclinicController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\ExaminationController;
use App\Http\Controllers\Doctor\MedicalRecordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

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

});

Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    
    Route::get('examinations',[ExaminationController::class, 'index'])->name('examinations.index');
    Route::get('examinations/{queue}/create',[ExaminationController::class, 'create'])->name('examinations.create');
    Route::patch('examinations/{queue}/start',[ExaminationController::class, 'start'])->name('examinations.start');
    Route::post('examinations/{queue}',[ExaminationController::class, 'store'])->name('examinations.store');

    Route::get('medical-records',[MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::get('medical-records/{medicalRecord}',[MedicalRecordController::class, 'show'])->name('medical-records.show');

});

require __DIR__.'/auth.php';
