<?php
namespace App\Http\Services;

use App\Repositories\NoteRepository;

class NoteService
{
    protected $noteRepository;

    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    public function getAllNotes()
    {
        return $this->noteRepository->getAllNotes();
    }

    public function findById($id)
    {
        if (!auth()->user()->hasPermissionTo('view-note')) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->noteRepository->findById($id);
    }

    public function update($id, $data)
    {
        if (!auth()->user()->hasPermissionTo('edit-note')) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->noteRepository->update($id, $data);
    }

    public function delete($id)
    {
        if (!auth()->user()->hasPermissionTo('delete-note')) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->noteRepository->delete($id);
    }

    public function store($data)
    {
        if (!auth()->user()->hasPermissionTo('create-note')) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->noteRepository->store($data);
    }

    public function getNotesByUserId($userId)
    {
        if (!auth()->user()->hasPermissionTo('view-note')) {
            throw new \Exception('Permission denied', 403);
        }

        return $this->noteRepository->getNotesByUserId($userId);
    }
}
