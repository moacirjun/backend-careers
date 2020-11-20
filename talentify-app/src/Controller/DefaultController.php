<?php

namespace App\Controller;

use App\Repository\JobRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    public function index(JobRepository $repository)
    {
        $jobs = $repository->findAllVisible();

        return $this->render('jobs/list_all.html.twig', ['jobs' => $jobs]);
    }
}