<?php

namespace App\Tests\Service\Job;

use App\Entity\JobInterface;
use App\Service\Job\Factory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FactoryTest extends KernelTestCase
{
    /** @var Factory */
    private $factory;

    protected function setUp()
    {
        parent::setUp();

        $this->bootKernel();
        $this->factory = self::$container->get(Factory::class);
    }

    public function testBlackFields()
    {
        $job = $this->factory->make([]);

        $this->assertEquals(null, $job->getId());
        $this->assertEquals(null, $job->getStatus());
        $this->assertEquals(null, $job->getTitle());
        $this->assertEquals(null, $job->getDescription());
        $this->assertEquals(null, $job->getSalary());
        $this->assertEquals(null, $job->getWorkplace());
    }

    public function testFullFilled()
    {
        $job = $this->factory->make([
            'title' => 'title test',
            'description' => 'desc test',
            'workplace' => ['province'=> 'SP', 'city' => 'Jundiaí'],
            'salary' => 3333,
            'status' => JobInterface::STATUS_VISIBLE,
        ]);

        $this->assertEquals(null, $job->getId());
        $this->assertEquals(JobInterface::STATUS_VISIBLE, $job->getStatus());
        $this->assertEquals('title test', $job->getTitle());
        $this->assertEquals('desc test', $job->getDescription());
        $this->assertEquals(3333, $job->getSalary());
        $this->assertEquals(['province'=> 'SP', 'city' => 'Jundiaí'], $job->getWorkplace());
    }

    public function testJsonMethod()
    {
        $data = [
            'title' => 'title test',
            'description' => 'desc test',
            'workplace' => ['province'=> 'SP', 'city' => 'Jundiaí'],
            'salary' => 3333,
            'status' => JobInterface::STATUS_VISIBLE,
        ];

        $job = $this->factory->makeFromJson(json_encode($data, true));
        $jobMadeByArray = $this->factory->make($data);

        $this->assertEquals(null, $job->getId());
        $this->assertEquals(JobInterface::STATUS_VISIBLE, $job->getStatus());
        $this->assertEquals('title test', $job->getTitle());
        $this->assertEquals('desc test', $job->getDescription());
        $this->assertEquals(3333, $job->getSalary());
        $this->assertEquals(['province'=> 'SP', 'city' => 'Jundiaí'], $job->getWorkplace());

        $this->assertEquals($jobMadeByArray->getId(), $job->getId());
        $this->assertEquals($jobMadeByArray->getStatus(), $job->getStatus());
        $this->assertEquals($jobMadeByArray->getTitle(), $job->getTitle());
        $this->assertEquals($jobMadeByArray->getDescription(), $job->getDescription());
        $this->assertEquals($jobMadeByArray->getSalary(), $job->getSalary());
        $this->assertEquals($jobMadeByArray->getWorkplace(), $job->getWorkplace());
    }
}