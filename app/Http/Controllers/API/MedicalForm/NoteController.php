<?php
namespace App\Http\Controllers;

use App\Http\Services\NoteService;
use App\Http\Resources\NoteResource;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function index()
    {
        try {
            $notes = $this->noteService->getAllNotes();
            return response()->json(['status' => 'success', 'data' => NoteResource::collection($notes)], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        try {
            $note = $this->noteService->findById($id);
            return response()->json(['status' => 'success', 'data' => new NoteResource($note)], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->all();
            $note = $this->noteService->update($id, $data);
            return response()->json(['status' => 'success', 'data' => new NoteResource($note)], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->noteService->delete($id);
            return response()->json(['status' => 'success', 'message' => 'Note deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $note = $this->noteService->store($data);
            return response()->json(['status' => 'success', 'data' => new NoteResource($note)], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function getNotesByUserId($userId)
    {
        try {
            $notes = $this->noteService->getNotesByUserId($userId);
            return response()->json(['status' => 'success', 'data' => NoteResource::collection($notes)], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
