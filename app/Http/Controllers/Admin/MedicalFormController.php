<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicalFormRequest;
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
        return view('medical-forms.create', compact('treatments'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
