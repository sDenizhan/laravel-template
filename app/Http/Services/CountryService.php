<?php
namespace App\Http\Services;

use App\Repositories\CountryRepository;

class CountryService
{
    public $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function get(array $where = [])
    {
        return $this->countryRepository->get($where);
    }

    public function create($data)
    {
        $country = $this->countryRepository->create($data);

        event(new \App\Events\CountryCreated($country));

        return $country;
    }

    public function update(int $id = null, array $data = [])
    {
        $update = $this->countryRepository->update($id, $data);

        event(new \App\Events\CountryUpdated($update));

        return $update;
    }

    public function delete(int $id = null)
    {
        $delete = $this->countryRepository->delete($id);

        event(new \App\Events\CountryDeleted($delete));

        return $delete;
    }

    public function view($id = null)
    {
        $country = $this->countryRepository->read($id);

        event(new \App\Events\CountryViewed($country));

        return $country;
    }
}
