<?php
namespace App\Http\Services;

use App\Events\InquiryViewed;
use App\Repositories\InquiryRepository;

class InquiryService
{
    public $inquiryRepository;

    public function __construct(InquiryRepository $inquiryRepository)
    {
        $this->inquiryRepository = $inquiryRepository;
    }

    public function get(array $where = [])
    {
        return $this->inquiryRepository->get($where);
    }

    public function create($data)
    {
        $inquiry = $this->inquiryRepository->create($data);

        event(new \App\Events\InquiryCreated($inquiry));

        return $inquiry;
    }

    public function view($id = null)
    {
        $inquiry = $this->inquiryRepository->read($id);

        event(new InquiryViewed($inquiry));

        return $inquiry;
    }

    public function update(int $id = null, array $data = [])
    {
        $update = $this->inquiryRepository->update($id, $data);

        event(new \App\Events\InquiryUpdated($update));

        return $update;
    }

}
