<?php

namespace App\Repositories;

use App\Models\Hospital;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HospitalRepository
{
    public function __construct(){}

    public function get(?array $where = [])
    {
        $hospitals = Hospital::query();

        if (!empty($where)) {
            $hospitals->where($where);
        }

        $records = $hospitals->get();

        if (!$records) {
            throw new ModelNotFoundException('Hospitals not found', 404);
        }

        return $records;
    }

    public function create(?array $data)
    {
        $created = Hospital::create($data);

        if (!$created) {
            throw new \Exception('Hospital not created', 404);
        }

        return $created;
    }

    public function read(?int $id = null)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            throw new ModelNotFoundException('Hospital not found', 404);
        }

        return $hospital;
    }
    public function update(?int $id = null, ?array $data = [])
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            throw new ModelNotFoundException('Hospital not found', 404);
        }

        $hospital->update($data);

        return $hospital;
    }

    public function delete(?int $id = null)
    {
        $hospital = Hospital::find($id);

        if (!$hospital) {
            throw new ModelNotFoundException('Hospital not found', 404);
        }

        $hospital->delete();

        return $hospital;
    }

    public function attachUsers(?int $hospitalId = null, ?array $users = [])
    {
        $hospital = Hospital::find($hospitalId);

        if (!$hospital) {
            throw new ModelNotFoundException('Hospital not found', 404);
        }

        $hospital->users()->attach($users);

        return $hospital;
    }
}
