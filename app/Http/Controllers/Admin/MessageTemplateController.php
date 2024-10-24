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

    public function index() : \Illuminate\View\View
    {
        return view('message-templates.index', [
            'templates' => MessageTemplate::orderBy('id','DESC')->paginate(75)
        ]);
    }

    public function create() : \Illuminate\View\View
    {
        $languages = Language::all();
        $treatments = Treatments::all();
        return view('message-templates.create', compact('languages', 'treatments'));
    }

    public function store(Request $request) : \Illuminate\Http\RedirectResponse
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

        $input = (object) $validated->validated();

        MessageTemplate::create([
            'treatment_id' => $input->treatment_id,
            'language_id' => $input->language_id,
            'title' => $input->title,
            'type' => $input->type,
            'action' => $input->action,
            'message' => $input->content,
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
