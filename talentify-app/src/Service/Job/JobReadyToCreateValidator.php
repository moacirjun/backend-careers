<?php

namespace App\Service\Job;

use App\Entity\Job;
use App\Exception\Job\InvalidDataToCreateJobException;

class JobReadyToCreateValidator
{
    public function validate(Job $job): bool
    {
        if (empty(trim($job->getTitle()))) {
            throw new InvalidDataToCreateJobException('The field title cannot be empty');
        }

        if (empty(trim($job->getDescription()))) {
            throw new InvalidDataToCreateJobException('The field description cannot be empty');
        }

        if (empty(trim($job->getStatus()))) {
            throw new InvalidDataToCreateJobException('The field status cannot be empty');
        }

        if (!is_numeric($job->getSalary())) {
            throw new InvalidDataToCreateJobException('The field salary must be a numeric value');
        }

        return true;
    }
}