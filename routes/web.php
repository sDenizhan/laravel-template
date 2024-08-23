<?php

use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MedicalFormController;
use App\Http\Controllers\Admin\MedicalFormQuestionController;
use App\Http\Controllers\Admin\MessageTemplateController;
use App\Http\Controllers\Admin\StatusController;
use App\Http\Controllers\Admin\TreatmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\MedicalFormController as MedicalForm;

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
});

Auth::routes();

Route::get('/medical-forms/show/{formId}', [MedicalForm::class, 'index'])->name('medical-forms.show');
Route::post('/medical-forms/update', [MedicalForm::class, 'update'])->name('medical-forms.update');


Route::prefix('webapi')->middleware([\App\Http\Middleware\CorsMiddleware::class])->group(function () {

    Route::get('/treatments', [App\Http\Controllers\API\TreatmentController::class, 'index'])->name('treatment.list');
    Route::post('/treatments', [App\Http\Controllers\API\TreatmentController::class, 'store'])->name('treatment.store');

    Route::get('/hospitals', [App\Http\Controllers\API\HospitalController::class, 'index'])->name('hospital.list');
    Route::post('/hospitals', [App\Http\Controllers\API\HospitalController::class, 'store'])->name('hospital.store');

    Route::get('/users', [App\Http\Controllers\API\UserController::class, 'index'])->name('user.list');
    Route::post('/users', [App\Http\Controllers\API\UserController::class, 'store'])->name('user.store');

    //inquiries
    Route::get('/inquiries/waiting', [App\Http\Controllers\API\InquiryController::class, 'waiting'])->name('inquiries.waiting');

});

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    //doctor
    Route::get('/doctors', [App\Http\Controllers\Admin\DoctorController::class, 'index'])->name('doctors.index');
    Route::get('/doctors/anaesthetist', [App\Http\Controllers\Admin\DoctorController::class, 'anaesthetist'])->name('doctors.anaesthetist');

    //inquaries
    Route::get('/inquiries/waiting', [InquiryController::class, 'waiting'])->name('inquiries.waiting');
    Route::get('/inquiries/approved', [InquiryController::class, 'approved'])->name('inquiries.approved');
    Route::post('/inquiries/show', [InquiryController::class, 'show'])->name('inquiries.show');
    Route::get('/inquiries/rejected/{inquiryId}', [InquiryController::class, 'rejected'])->name('inquiries.rejected');
    Route::post('/inquiries/statusUpdate', [InquiryController::class, 'statusUpdate'])->name('inquiries.statusUpdate');

    Route::post('/inquiries/send_form_mail', [InquiryController::class, 'sendFormMail'])->name('inquiries.send_form_mail');
    Route::post('/inquiries/send_to_whatsapp', [InquiryController::class, 'sendToWhatsapp'])->name('inquiries.send_to_whatsapp');

    //medical-forms-questions
    Route::get('/medical-form-questions/add-question/{formId}', [MedicalFormQuestionController::class, 'addQuestion'])->name('medical-form-questions.add-question');
    Route::get('/medical-form-questions/get-questions/{formId}', [MedicalFormQuestionController::class, 'getMedicalFormQuestions'])->name('medical-form-questions.formQuestions');
    Route::post('/medical-form-questions/store', [MedicalFormQuestionController::class, 'store'])->name('medical-form-questions.store');
    Route::post('/medical-form-questions/answerStore', [MedicalFormQuestionController::class, 'answerStore'])->name('medical-form-questions.answerStore');
    Route::get('/medical-forms/import', [MedicalFormController::class, 'import'])->name('medical-forms.import');
    Route::post('/medical-forms/import', [MedicalFormController::class, 'importStore'])->name('medical-forms.importStore');
    Route::get('/medical-forms/export/{formId}', [MedicalFormController::class, 'export'])->name('medical-forms.export');

    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
        'permissions' => PermissionController::class,
        'treatments' => TreatmentController::class,
        'status' => StatusController::class,
        'inquiries' => InquiryController::class,
        'hospitals' => HospitalController::class,
        'doctors' => DoctorController::class,
        'medical-forms' => MedicalFormController::class,
        'medical-form-questions' => MedicalFormQuestionController::class,
        'languages' => LanguageController::class,
        'message-template' => MessageTemplateController::class,
    ]);
});
