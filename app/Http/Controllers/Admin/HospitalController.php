<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHospitalRequest;
use App\Http\Requests\UpdateHospitalRequest;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view-hospital')->only(['index', 'show']);
        $this->middleware('permission:create-hospital')->only(['create', 'store']);
        $this->middleware('permission:edit-hospital')->only(['edit', 'update']);
        $this->middleware('permission:delete-hospital')->only(['destroy']);
    }

    public function index()
    {
        $hospitals = Hospital::all();
        return view('hospital.index', compact('hospitals'));
    }

    public function create()
    {
        $doctors = User::role('Doctor')->get();
        $anaesthetists = User::role('Anaesthetist')->get();
        return view('hospital.create', compact('doctors', 'anaesthetists'));
    }

    public function store(StoreHospitalRequest $request)
    {
        $doctors = $request->input('doctors');
        $anaesthetists = $request->input('anaesthetists');

        $validated = Arr::except($request->validated(), ['doctors', 'anaesthetists']);
        $hospital = Hospital::create($validated);

        if ( isset($doctors) ) {
            $hospital = Hospital::find($hospital->id);
            $hospital->users()->attach($doctors);
        }

        if ( isset($anaesthetists) ) {
            $hospital = Hospital::find($hospital->id);
            $hospital->users()->attach($anaesthetists);
        }

        return redirect()->route('admin.hospitals.create')->with('success', 'Hospital created successfully.');
    }

    public function show(string $id)
    {
        //
        $hospital = Hospital::find($id);
        $doctors = $hospital->users()->get() ?? [];

        return view('hospital.show', compact('hospital', 'doctors'));
    }

    public function edit(string $id)
    {
        $hospital = Hospital::find($id);
        $doctors = User::role('Doctor')->get();
        $selectedDoctors = $hospital->users()->get() ?? [];

        return view('hospital.edit', compact('hospital', 'doctors', 'selectedDoctors'));
    }

    public function update(UpdateHospitalRequest $request, string $id)
    {
        $doctors = $request->input('doctors');
        $validated = Arr::except($request->validated(), 'doctors');
        $hospital = Hospital::find($id);
        $hospital->update($validated);

        if ( isset($doctors) ) {
            $hospital->users()->sync($doctors);
        }

        return redirect()->route('admin.hospitals.edit', $id)->with('success', 'Hospital updated successfully.');
    }

    public function destroy(string $id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->delete();

        return redirect()->route('admin.hospitals.index')->with('success', 'Hospital deleted successfully.');
    }
}
