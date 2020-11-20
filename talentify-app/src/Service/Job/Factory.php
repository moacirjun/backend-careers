<?php

namespace App\Service\Job;

use App\Entity\Job;

class Factory
{
    /**
     * @param array $data
     * @return Job
     *
     * $data = [
     *      'title' => 'title test',
     *      'description' => 'desc test',
     *      'workplace' => ['province'=> 'SP', 'city' => 'Jundiaí'],
     *      'salary' => 3333,
     *      'status' => JobInterface::STATUS_VISIBLE,
     * ]
     */
    public function make(array $data): Job
    {
        $newJob = new Job();

        if (isset($data['title'])) {
            $newJob->setTitle($data['title']);
        }

        if (isset($data['description'])) {
            $newJob->setDescription($data['description']);
        }

        if (isset($data['workplace'])) {
            $newJob->setWorkplace($data['workplace']);
        }

        if (isset($data['salary'])) {
            $newJob->setSalary($data['salary']);
        }

        if (!empty($data['status'])) {
            $newJob->setStatus($data['status']);
        }

        return $newJob;
    }

    public function makeFromJson(string $jobJson): Job
    {
        return $this->make(json_decode($jobJson, true));
    }
}