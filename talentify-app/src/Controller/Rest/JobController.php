<?php

namespace App\Controller\Rest;

use App\Repository\JobRepository;
use App\Service\CreateJobService;
use App\Service\Job\Factory as JobFactory;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class JobController extends AbstractFOSRestController
{
    /**
     * @param JobRepository $repository
     * @return View
     */
    public function listOpenedJobs(JobRepository $repository)
    {
        $jobs = $repository->findAllVisible();

        return View::create($jobs, Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param JobFactory $jobFactory
     * @param CreateJobService $createJobService
     * @return View
     */
    public function save(Request $request, CreateJobService $createJobService, JobFactory $jobFactory)
    {
        $newJob = $jobFactory->makeFromJson($request->getContent());
        $createJobService->create($newJob);

        return View::create([], Response::HTTP_CREATED);
    }
}