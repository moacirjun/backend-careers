<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\CreateJobType;
use App\Service\CreateJobService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class JobController extends AbstractController
{
    public function create()
    {
        $blankJob = new Job();
        $form = $this->createForm(CreateJobType::class, $blankJob);

        return $this->render('jobs/create_form.html.twig', ['form' => $form->createView()]);
    }

    public function createSuccess()
    {
        return $this->render('jobs/create_success.html.twig');
    }

    public function save(Request $request, CreateJobService $createJobService)
    {
        $form = $this->createForm(CreateJobType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $createJobService->create($form->getData());

            return $this->redirectToRoute('create_job_success');
        }

        return $this->render('jobs/create_form.html.twig', ['form' => $form->createView()]);
    }
}