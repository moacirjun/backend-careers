<?php

namespace App\Service;

use App\Entity\Job;
use InvalidArgumentException;
use Doctrine\ORM\EntityManagerInterface;

class CreateJobService
{
    /** EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->em = $entityManagerInterface;
    }

    public function create(Job $job)
    {
        if (empty(trim($job->getTitle()))) {
            throw new InvalidArgumentException('The field title cannot be empty');
        }

        if (empty(trim($job->getDescription()))) {
            throw new InvalidArgumentException('The field description cannot be empty');
        }

        if (empty(trim($job->getStatus()))) {
            throw new InvalidArgumentException('The field status cannot be empty');
        }

        if (!is_numeric($job->getSalary())) {
            throw new InvalidArgumentException('The field salary must be a numeric value');
        }

        $job->setTitle($this->sanitizeStringField($job->getTitle()));
        $job->getDescription($this->sanitizeStringField($job->getDescription()));
        $job->getStatus($this->sanitizeStringField($job->getStatus()));

        $this->em->persist($job);
        $this->em->flush();
    }

    private function sanitizeStringField(string $string)
    {
        return addslashes(trim($string));
    }
}