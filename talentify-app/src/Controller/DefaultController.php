<?php

namespace App\Controller;

use App\Entity\Job;
use App\Entity\JobInterface;
use App\Form\CreateJobType;
use App\Service\CreateJobService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function index(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Job::class);
        $jobs = $repository->findBy(['status' => JobInterface::STATUS_VISIBLE]);

        return $this->render('jobs/list_all.html.twig', ['jobs' => $jobs]);
    }
}