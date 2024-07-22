<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Language;
use App\Models\Status;
use App\Models\Treatments;
use App\Models\User;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('permission:create-permission|edit-permission|delete-permission', ['only' => ['index','show']]);
//        $this->middleware('permission:create-permission', ['only' => ['create','store']]);
//        $this->middleware('permission:edit-permission', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }

    public function waiting()
    {
        $inquiries = Inquiry::where(['status' => 0])->get();
        return view('inquiry.waiting', compact('inquiries'));
    }

    public function approved()
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(\App\Enums\Gender::toArray());

        $inquiries = Inquiry::all();
        return view('inquiry.waiting', compact('inquiries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $inquiry = Inquiry::find($id);
        $coordinators = User::whereHas('roles', function ($query) {
            $query->where('name', 'coordinator');
        })->get();
        $treatments = Treatments::all();
        $languages = Language::all();

        $html = view('components.backend.inquiries.modal.edit-form', compact('inquiry', 'coordinators', 'treatments', 'languages'))->render();
        return response()->json(['status' => 'success', 'html' => $html]);
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
