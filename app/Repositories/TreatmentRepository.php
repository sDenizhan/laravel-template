<?php

namespace App\Repositories;

use App\Models\Treatments;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TreatmentRepository
{
    public $treamtent;

    public function __construct(Treatments $treatment)
    {
        $this->treatment = $treatment;
    }

    public function get($where = [])
    {
        $treatments = $this->treatment->query();

        if (!empty($where)) {
            $treatments->where($where);
        }

        $records = $treatments->get();

        if (!$records) {
            throw new ModelNotFoundException('Treatment not found', 404);
        }

        return $records;
    }

    public function create($data)
    {
        $created = $this->treatment->create($data);

        if (!$created) {
            throw new \Exception('Treatment not created', 404);
        }

        return $created;
    }

    public function read($id = null)
    {
        $treatment = $this->treatment->find($id);

        if (!$treatment) {
            throw new ModelNotFoundException('Treatment not found', 404);
        }

        return $treatment;
    }

    public function update(int $id = null, array $data = [])
    {
        $treatment = $this->treatment->find($id);

        if (!$treatment) {
            throw new ModelNotFoundException('Treatment not found', 404);
        }

        $treatment->update($data);

        return $treatment;
    }

    public function delete(int $id = null)
    {
        $treatment = $this->treatment->findOrFail($id);

        if (!$treatment) {
            throw new ModelNotFoundException('Treatment not found', 404);
        }

        $treatment->delete();

        return $treatment;
    }

}
