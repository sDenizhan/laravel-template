<?php

namespace App\Repositories;

use App\Models\MedicalFormNotes;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class NoteRepository
{
    public function __construct() {}

    public function get(array $where = [])
    {
        $notes = MedicalFormNotes::query();

        if (!empty($where)) {
            $notes->where($where);
        }

        $records = $notes->get();

        if (!$records) {
            throw new ModelNotFoundException('Inquiries not found', 404);
        }

        return $records;
    }

    public function create($data)
    {
        $created = MedicalFormNotes::create($data);

        if (!$created) {
            throw new \Exception('Inquiry not created', 404);
        }

        return $created;
    }

    public function read($id = null)
    {
        $note = MedicalFormNotes::find($id);

        if (!$note) {
            throw new ModelNotFoundException('Inquiry not found', 404);
        }

        return $note;
    }

    public function update(int $id = null, array $data = [])
    {
        $note = MedicalFormNotes::find($id);

        if (!$note) {
            throw new ModelNotFoundException('Inquiry not found', 404);
        }

        $note->update($data);

        return $note;
    }
    public function delete(int $id = null)
    {
        $note = MedicalFormNotes::findOrFail($id);

        if (!$note) {
            throw new ModelNotFoundException('Inquiry not found', 404);
        }

        $note->delete();

        return $note;
    }

}
