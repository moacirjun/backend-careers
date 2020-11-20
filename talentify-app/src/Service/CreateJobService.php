<?php

namespace App\Service;

use App\Entity\Job;
use App\Service\Job\JobReadyToCreateValidator;
use Doctrine\ORM\EntityManagerInterface;

class CreateJobService
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var JobReadyToCreateValidator */
    private $validator;

    /**
     * CreateJobService constructor.
     * @param EntityManagerInterface $em
     * @param JobReadyToCreateValidator $validator
     */
    public function __construct(EntityManagerInterface $em, JobReadyToCreateValidator $validator)
    {
        $this->em = $em;
        $this->validator = $validator;
    }

    public function create(Job $job)
    {
        $this->validator->validate($job);

        $job->setTitle($this->sanitizeStringField($job->getTitle()));
        $job->setDescription($this->sanitizeStringField($job->getDescription()));
        $job->setStatus($this->sanitizeStringField($job->getStatus()));

        $workplaceData = $job->getWorkplace();

        $job->setWorkplace([
            'province' => $workplaceData['province'] ?? '', // Normalizes all workplaces from database.
            'city' => $workplaceData['city'] ?? '',
            'street' => $workplaceData['street'] ?? '',
        ]);

        $this->em->persist($job);
        $this->em->flush();
    }

    private function sanitizeStringField(string $string)
    {
        return addslashes(trim($string));
    }
}