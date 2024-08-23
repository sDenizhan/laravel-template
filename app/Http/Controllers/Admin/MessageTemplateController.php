<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\MessageTemplate;
use App\Models\Treatments;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-message|edit-message|delete-message', ['only' => ['index','show']]);
        $this->middleware('permission:create-message', ['only' => ['create','store']]);
        $this->middleware('permission:edit-message', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-message', ['only' => ['destroy']]);
    }

    public function index()
    {
        return view('message-templates.index', [
            'templates' => MessageTemplate::orderBy('id','DESC')->paginate(75)
        ]);
    }

    public function create()
    {
        $languages = Language::all();
        $treatments = Treatments::all();
        return view('message-templates.create', compact('languages', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = \Validator::make($request->all(), [
            'title' => 'required',
            'language_id' => 'required',
            'treatment_id' => 'required',
            'type' => 'required',
            'action' => 'required',
            'content' => 'required',
        ]);

        if ( $validated->fails() ) {
            return redirect()->back()->withErrors($validated)->withInput();
        }

        MessageTemplate::create([
            'treatment_id' => $request->treatment_id,
            'language_id' => $request->language_id,
            'title' => $request->title,
            'type' => $request->type.'_'.$request->action,
            'message' => $request->content,
        ]);

        return redirect()->route('admin.message-template.index')
            ->with('success','Message template created successfully.');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
