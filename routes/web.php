<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TenantController;
use App\Http\Controllers\Admin\TenantAdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\PresenceController;
use App\Http\Controllers\Admin\DossierController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('principal.accueil');

Route::get('/register-tenant', [TenantController::class,'create'])->name('tenant.create');
Route::post('/register-tenant', [TenantController::class,'store'])->name('tenant.store');

Route::prefix('admin')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/', [TenantAdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('tenants', TenantAdminController::class);

	Route::resource('students', App\Http\Controllers\Admin\StudentController::class)
    ->names('admin.students');

	Route::prefix('students/{student}')->group(function () {
	    Route::get('attendances', [AttendanceController::class, 'index'])->name('students.attendances.index');
	    Route::get('attendances/create', [AttendanceController::class, 'create'])->name('students.attendances.create');
	    Route::post('attendances', [AttendanceController::class, 'store'])->name('students.attendances.store');
	});

	Route::prefix('students/{student}')->group(function () {
	    Route::get('files', [StudentFileController::class, 'index'])->name('students.files.index');
	    Route::get('files/create', [StudentFileController::class, 'create'])->name('students.files.create');
	    Route::post('files', [StudentFileController::class, 'store'])->name('students.files.store');
	    Route::get('files/{file}/download', [StudentFileController::class, 'download'])->name('students.files.download');
	});

	Route::prefix('admin')->name('admin.')->group(function () {
	    Route::resource('students', StudentController::class);

	    Route::get('students/{student}/presences/create', [PresenceController::class, 'create'])->name('presences.create');
	    Route::post('students/{student}/presences', [PresenceController::class, 'store'])->name('presences.store');

	    Route::get('students/{student}/dossiers/create', [DossierController::class, 'create'])->name('dossiers.create');
	    Route::post('students/{student}/dossiers', [DossierController::class, 'store'])->name('dossiers.store');

	    Route::post('/students/{student}/assign-classes', [StudentController::class, 'assignClasses'])->name('students.assignClasses');
	    Route::delete('/students/{student}/remove-class/{class}', [StudentController::class, 'removeClass'])
    	->name('students.removeClass');

	    
		// Route::post('/students/{student}/presences', [PresenceController::class, 'store'])->name('presences.store');
		Route::delete('/presences/{presence}', [PresenceController::class, 'destroy'])->name('presences.destroy');

		// Route::post('/students/{student}/dossiers', [DossierController::class, 'store'])->name('dossiers.store');
		Route::delete('/dossiers/{dossier}', [DossierController::class, 'destroy'])->name('dossiers.destroy');


		//CLASSES
	    Route::resource('classes', ClassController::class);

	    Route::get('classes/{class}/assign-students', [ClassController::class, 'assignStudents'])->name('classes.assign.students');
	    Route::post('classes/{class}/assign-students', [ClassController::class, 'storeStudents'])->name('classes.store.students');

	    Route::get('classes/{class}/assign-teachers', [ClassController::class, 'assignTeachers'])->name('classes.assign.teachers');
	    Route::post('classes/{class}/assign-teachers', [ClassController::class, 'storeTeachers'])->name('classes.store.teachers');		

	    Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class);
	});


});

require __DIR__.'/auth.php';
