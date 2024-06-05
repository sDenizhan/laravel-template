<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicalFormRequest;
use App\Http\Requests\UpdateMedicalFormRequest;
use App\Models\Language;
use App\Models\MedicalForm;
use App\Models\Treatments;
use Illuminate\Http\Request;

class MedicalFormController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('permission:read-medical-forms')->only('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = MedicalForm::all();
        return view('medical-forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $treatments = Treatments::where(['status' => Status::Active->value])->get();
        $languages = Language::all();
        return view('medical-forms.create', compact('treatments', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalFormRequest $request)
    {
        $validated  = $request->validated();
        $medicalForm = MedicalForm::create($validated);

        if ($medicalForm) {
            return redirect()->route('admin.medical-forms.index')->with('success', 'Medical Form created successfully');
        } else {
            return redirect()->route('admin.medical-forms.index')->with('error', 'Medical Form creation failed');
        }
    }

    public function export(?string $id)
    {
        //xml export
        if ($id) {
            $form = MedicalForm::find($id);
            $xml = new \SimpleXMLElement('<medical-form></medical-form>');
            $xml->addChild('title', $form->title);
            $xml->addChild('description', $form->description);
            $xml->addChild('treatment_id', $form->treatment_id);
            $xml->addChild('language_id', $form->language_id);

            $settings = $form->settings;
            $settingsXml = $xml->addChild('settings');
            foreach ($settings as $key => $value) {
                $settingsXml->addChild($key, $value);
            }

            $questions = $form->questions;
            $questionsXml = $xml->addChild('questions');
            foreach ($questions as $question) {
                $questionXml = $questionsXml->addChild('question');
                $questionXml->addChild('medical_form_id', $question->medical_form_id);
                $questionXml->addChild('question', $question->question);
                $questionXml->addChild('description', $question->description);
                $questionXml->addChild('type', $question->type);
                $questionXml->addChild('order', $question->order);

                $rules = $question->rules;
                $rulesXml = $questionXml->addChild('rules');
                foreach ($rules as $key => $value) {
                    $rulesXml->addChild($key, $value);
                }


                $answers = $question->answers;
                $answersXml = $questionXml->addChild('answers');
                foreach ($answers as $answer) {
                    $answerXml = $answersXml->addChild('answer');
                    $answerXml->addChild('medical_form_question_id', $answer->medical_form_question_id);
                    $answerXml->addChild('medical_form_id', $answer->medical_form_id);
                    $answerXml->addChild('answer', $answer->answer);
                    $answerXml->addChild('order', $answer->order);
                }
            }

            $xml->asXML(public_path('exports/medical-form-' . $id . '.xml'));
            return response()->download(public_path('exports/medical-form-' . $id . '.xml'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $form = MedicalForm::find($id);
        $treatments = Treatments::where(['status' => Status::Active->value])->get();
        $languages = Language::all();
        return view('medical-forms.edit', compact('form', 'treatments', 'languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalFormRequest $request, string $id)
    {
        $form = MedicalForm::find($id);

        if ($form) {
            $validated = $request->validated();
            $form->update($validated);
            return redirect()->route('admin.medical-forms.index')->with('success', 'Medical Form updated successfully');
        } else {
            return redirect()->route('admin.medical-forms.index')->with('error', 'Medical Form not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
