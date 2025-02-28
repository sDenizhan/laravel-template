<?php
namespace App\Repositories;

use App\Models\Inquiry;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class InquiryRepository
{
    public function __construct() {}

    public function get(array $where = [])
    {
        $inquiries = Inquiry::with(['treatment', 'coordinator', 'answers'])->query();

        if (!empty($where)) {
            $inquiries->where($where);
        }

        $records = $inquiries->get();

        if (!$records) {
            throw new ModelNotFoundException('Inquiries not found', 404);
        }

        return $records;
    }

    public function create($data)
    {
        $created = Inquiry::create($data);

        if (!$created) {
            throw new \Exception('Inquiry not created', 404);
        }

        return $created;
    }

    public function read($id = null)
    {
        $inquiry = Inquiry::find($id);

        if (!$inquiry) {
            throw new ModelNotFoundException('Inquiry not found', 404);
        }

        return $inquiry;
    }

    public function update(int $id = null, array $data = [])
    {
        $inquiry = Inquiry::find($id);

        if (!$inquiry) {
            throw new ModelNotFoundException('Inquiry not found', 404);
        }

        $inquiry->update($data);

        return $inquiry;
    }
    public function delete(int $id = null)
    {
        $inquiry = Inquiry::findOrFail($id);

        if (!$inquiry) {
            throw new ModelNotFoundException('Inquiry not found', 404);
        }

        $inquiry->delete();

        return $inquiry;
    }
}
