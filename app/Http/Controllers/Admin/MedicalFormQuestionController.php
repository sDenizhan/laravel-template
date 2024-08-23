<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicalFormQuestionRequest;
use App\Models\MedicalForm;
use App\Models\MedicalFormQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MedicalFormQuestionController extends Controller
{
    public function addQuestion(?int $formId)
    {
        $form = MedicalForm::find($formId);
        if ( ! $form) {
            return redirect()->route('admin.medical-forms.index')->with('error', 'Medical Form not found');
        }

        $questions = $form->questions()->get();

        $maxStep = collect($questions)->max('step');

        return view('medical-forms.add-question', compact('form', 'questions', 'maxStep'));
    }

    public function getMedicalFormQuestions(?int $formId = null)
    {

        $form = MedicalForm::find($formId);

        if ( ! $form) {
            return response()->json([
                'status' => 'error',
                'message' => 'Medical Form not found'
            ], 200);
        }

        $questions = $form->questions()->get();

        if ( ! $questions->count() ) {
            return response()->json([
                'status' => 'error',
                'message' => 'No questions found',
                'html' => view('components.backend.medical-forms.list-questions-and-answers', ['steps' => $form->steps, 'questions' => []])->render()
            ], 200);
        } else {
            return response()->json([
                'status' => 'success',
                'questions' => $questions,
                'html' => view('components.backend.medical-forms.list-questions-and-answers', ['steps' => $form->steps, 'questions' => $questions])->render()
            ], 200);
        }
    }

    public function answerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'medical_form_id' => 'required|integer',
            'medical_form_question_id' => 'required|integer',
            'answer' => 'required|string',
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $question = MedicalForm::find($request->medical_form_id)->questions()->find($request->medical_form_question_id);

        if ( ! $question ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Question not found'
            ], 200);
        } else {
            $answer = $question->answers()->create($validator->validated());

            if ( $answer ) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Answer added successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to add answer'
                ], 200);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'medical_form_id' => 'required|integer',
            'question' => 'required|string',
            'description' => 'nullable|string',
            'type' => 'required|string',
            'rules' => 'nullable|array',
            'order' => 'required|integer',
            'step' => 'required|integer'
        ]);

        if ( $validator->fails() ) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $question = MedicalForm::find($request->medical_form_id)->questions()->create($validator->validated());

        if ( $question ) {
            return response()->json([
                'status' => 'success',
                'message' => 'Question added successfully'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add question'
            ], 200);
        }
    }

    public function destroy(string $questionId)
    {
        $question = MedicalFormQuestion::find($questionId);
        if ( $question->delete() ){
            return  response()->json([
                'status' => 'success',
                'message' => __('Question Deleted!')
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => __('Question Not Deleted!')
            ]);
        }
    }
}
