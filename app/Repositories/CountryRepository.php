<?php
namespace App\Repositories;

use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CountryRepository {

    public function __construct(){}

    public function get(array $where = [])
    {
        $countries = Country::query();

        if (!empty($where)) {
            $countries->where($where);
        }

        $records = $countries->get();

        if (!$records) {
            throw new ModelNotFoundException('Countries not found', 404);
        }

        return $records;
    }

    public function create($data)
    {
        $created = Country::create($data);

        if (!$created) {
            throw new \Exception('Country not created', 404);
        }

        return $created;
    }

    public function read($id = null)
    {
        $country = Country::find($id);

        if (!$country) {
            throw new ModelNotFoundException('Country not found', 404);
        }

        return $country;
    }

    public function update(int $id = null, array $data = [])
    {
        $country = Country::find($id);

        if (!$country) {
            throw new ModelNotFoundException('Country not found', 404);
        }

        $country->update($data);

        return $country;
    }

    public function delete(int $id = null)
    {
        $country = Country::find($id);

        if (!$country) {
            throw new ModelNotFoundException('Country not found', 404);
        }

        $country->delete();

        return $country;
    }
}
