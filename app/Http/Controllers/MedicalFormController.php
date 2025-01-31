<?php

namespace App\Http\Controllers;

use App\Enums\InquiryStatus;
use App\Models\Inquiry;
use App\Models\MedicalForm;
use App\Models\MedicalFormPatientAnswers;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MedicalFormController extends Controller
{
    public function index(Request $request, ?string $formId)
    {   
        $patientAnswers = MedicalFormPatientAnswers::where(['code' => $formId])->first();

        if (!$patientAnswers) {
            return __('The form you are looking for could not be found.');
        }

        //üye giriş yapılmışsa formu uzatalım
        if ( !is_null(auth()->user()) && auth()->user()->id == $patientAnswers->user_id ) {
            MedicalFormPatientAnswers::where(['id' => $patientAnswers->id ])->update([
                'last_answers_at' => Carbon::create(Carbon::now())->addDays(7)
            ]);
        }

        //date control
        $dateControl = Carbon::create(Carbon::now())->diff($patientAnswers->last_answers_at);

        if ($dateControl->invert == 1)
        {
            return __(':days days have passed since the allowed time to fill out the form. To continue the process, either log in or contact your coordinator.', ['days' => $dateControl->days]);
        }

        //form wizards
        $form = MedicalForm::find($patientAnswers->medical_form_id);

        if (!$form) {
            return __('The form you are looking for could not be found..!');
        }

        return view('themes.frontend.default.medical-forms.show', compact('form', 'patientAnswers'));
    }

    public function update(Request $request) {

        $validator = \Validator::make($request->all(), [
            'formId' => 'required',
            'questions' => 'array|nullable'
        ]);

        if ( $validator->fails() ) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first() ]);
        }

        $validated = $validator->validated();

        $answers = MedicalFormPatientAnswers::where(['code' => $validated['formId']])->first();

        if (is_null($answers)) {
            return response()->json(['status' => 'error', 'message' => __('Medical Form Tespit Edilemedi..!')]);
        }

        $answers->update([
            'answers' => $validated['questions']
        ]);

        return response()->json(['status' => 'success', 'message' => __('Medical Form Updated..!')]);
    }

    public function finishUpdate(Request $request) {

        $validator = \Validator::make($request->all(), [
            'formId' => 'required',
            'submit' => 'required',
        ]);

        if ( $validator->fails() ) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first() ]);
        }

        $validated = $validator->validated();

        if ( $validated['submit'] ) {
            $inquiryId = MedicalFormPatientAnswers::where(['code' => $validated['formId']])->first()->inquiry_id;
            $update = Inquiry::where(['id' => $inquiryId])->update(['status' => InquiryStatus::FORM_RECEIVED->value ]);

            return response()->json(['status' => 'success', 'message' => __('Medical Form Updated..!')]);
        }
        else
        {
            return response()->json(['status' => 'error', 'message' => __('Medical Form Not Updated..!')]);
        }
    }
}
