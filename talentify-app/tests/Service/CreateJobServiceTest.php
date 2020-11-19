<?php

namespace App\Tests\Service;

use App\Entity\Job;
use App\Entity\JobInterface;
use App\Service\CreateJobService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManagerInterface;

class CreateJobServiceTest extends KernelTestCase
{
    /**
     * @var CreateJobService
     */
    private $service;

    /**
     * @var Job
     */
    private $job;

    protected function setUp()
    {
        parent::setUp();
        
        $this->bootKernel();
        $this->service = self::$container->get(CreateJobService::class);

        $this->job = new Job();
    }

    public function nullValuesProvider()
    {
        return [
            [
                'title' => null,
                'desc' => 'desc',
                'status' => JobInterface::STATUS_VISIBLE,
                'workplace' => ['postcode' => 12312312, 'number' => 123],
                'salary' => 3500
            ], [
                'title' => 'title',
                'desc' => null,
                'status' => JobInterface::STATUS_VISIBLE,
                'workplace' => ['postcode' => 12312312, 'number' => 123],
                'salary' => 3500
            ], [
                'title' => 'title',
                'desc' => 'desc',
                'status' => null,
                'workplace' => ['postcode' => 12312312, 'number' => 123],
                'salary' => 3500
            ], [
                'title' => 'title',
                'desc' => 'desc',
                'status' => JobInterface::STATUS_VISIBLE,
                'workplace' => ['postcode' => 12312312, 'number' => 123],
                'salary' => null
            ]
        ];
    }

    /**
     * @dataProvider nullValuesProvider
     */
    public function testNullValues($title, $desc, $status, $workplace, $salary)
    {
        if (null !== $title) {
            $this->job->setTitle($title);
        }

        if (null !== $desc) {
            $this->job->setDescription($desc);
        }

        if (null !== $status) {
            $this->job->setStatus($status);
        }

        if (null !== $workplace) {
            $this->job->setWorkplace($workplace);
        }

        if (null !== $salary) {
            $this->job->setSalary($salary);
        }
     
        $this->expectException(InvalidArgumentException::class);
        $this->service->create($this->job);
    }

    public function testFullfiledJob()
    {
        $this->job->setTitle('title');
        $this->job->setDescription('desc');
        $this->job->setStatus(JobInterface::STATUS_VISIBLE);
        $this->job->setWorkplace(['postcode' => 12312312, 'number' => 123]);
        $this->job->setSalary(3500);
        
        /** @var EntityManagerInterface $em */
        $em = self::$container->get('doctrine.orm.entity_manager');
        $con = $em->getConnection();
        $con->beginTransaction();

        $this->service->create($this->job);

        $repository = $em->getRepository(Job::class);
        $createdJob = $repository->find(1);
        
        $this->assertEquals($this->job->getTitle(), $createdJob->getTitle());
        $this->assertEquals($this->job->getDescription(), $createdJob->getDescription());
        $this->assertEquals($this->job->getStatus(), $createdJob->getStatus());
        $this->assertEquals($this->job->getWorkplace(), $createdJob->getWorkplace());
        $this->assertEquals($this->job->getSalary(), $createdJob->getSalary());

        $con->rollBack();
    }
}