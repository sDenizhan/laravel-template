<?php
namespace App\Http\Services;

use App\Repositories\HospitalRepository;

class HospitalService {
    protected $hospitalRepository;

    public function __construct(HospitalRepository $hospitalRepository)
    {
        $this->hospitalRepository = $hospitalRepository;
    }

    public function get(?array $where = [])
    {
        return $this->hospitalRepository->get($where);
    }

    public function create(?array $data)
    {
        $created = $this->hospitalRepository->create($data);

        event(new \App\Events\HospitalCreated($created));

        return $created;
    }

    public function view(?int $id = null)
    {
        $view = $this->hospitalRepository->read($id);

        event(new \App\Events\HospitalViewed($view));

        return $view;
    }

    public function update(?int $id = null, ?array $data = [])
    {
        $updated = $this->hospitalRepository->update($id, $data);

        event(new \App\Events\HospitalUpdated($updated));

        return $updated;
    }

    public function delete(?int $id = null)
    {
        $deleted = $this->hospitalRepository->delete($id);

        event(new \App\Events\HospitalDeleted($deleted));

        return $deleted;
    }

    public function attachUsers(?int $hospitalId = null, ?array $users = [])
    {
        $attached = $this->hospitalRepository->attachUsers($hospitalId, $users);

        event(new \App\Events\HospitalUserAttached($attached));

        return $attached;
    }

}
