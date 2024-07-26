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
            'messageTemplates' => MessageTemplate::orderBy('id','DESC')->paginate(75)
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
        dd($request->all());
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
