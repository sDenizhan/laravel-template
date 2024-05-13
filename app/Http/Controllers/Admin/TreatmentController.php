<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;
use App\Models\Treatments;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-treatment|edit-treatment|delete-treatment', ['only' => ['index','show']]);
        $this->middleware('permission:create-treatment', ['only' => ['create','store']]);
        $this->middleware('permission:edit-treatment', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-treatment', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $treatments = Treatments::all();
        return view('treatments.index', compact('treatments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('treatments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTreatmentRequest $request)
    {
        Treatments::create([
            'name' => $request->name,
            'status' => $request->status
        ]);

        return redirect()->route('admin.treatments.index')
            ->with('success', 'Treatment created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('admin.treatments.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $treatment = Treatments::find($id);
        return view('treatments.edit', compact('treatment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTreatmentRequest $request, string $id)
    {
        $treatment = Treatments::find($id);
        $treatment->name = $request->name;
        $treatment->status = $request->status;
        $treatment->save();

        return redirect()->route('admin.treatments.index')
            ->with('success', 'Treatment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //remove treatment
        $treatment = Treatments::find($id);
        $treatment->delete();

        return redirect()->route('admin.treatments.index')
            ->with('success', 'Treatment deleted successfully.');
    }
}
