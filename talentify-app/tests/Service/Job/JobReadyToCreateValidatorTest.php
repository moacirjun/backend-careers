<?php

namespace App\Tests\Service\Job;

use App\Entity\JobInterface;
use App\Exception\Job\InvalidDataToCreateJobException;
use App\Service\Job\Factory;
use App\Service\Job\JobReadyToCreateValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JobReadyToCreateValidatorTest extends KernelTestCase
{
    /** @var Factory */
    private $factory;

    /** @var JobReadyToCreateValidator */
    private $validator;

    protected function setUp()
    {
        parent::setUp();

        $this->bootKernel();
        $this->factory = self::$container->get(Factory::class);
        $this->validator = self::$container->get(JobReadyToCreateValidator::class);
    }

    public function testWithoutWorkplace()
    {
        $job = $this->factory->make([
            'title' => 'title test',
            'description' => 'desc test',
            'salary' => 3333,
            'status' => JobInterface::STATUS_VISIBLE,
        ]);

        $this->assertTrue($this->validator->validate($job));
    }

    public function testWithoutTitleException()
    {
        $job = $this->factory->make([
            'description' => 'desc test',
            'salary' => 3333,
            'status' => JobInterface::STATUS_VISIBLE,
        ]);

        $this->expectException(InvalidDataToCreateJobException::class);
        $this->validator->validate($job);
    }

    public function testWithoutDescriptionException()
    {
        $job = $this->factory->make([
            'title' => 'test title',
            'salary' => 3333,
            'status' => JobInterface::STATUS_VISIBLE,
        ]);

        $this->expectException(InvalidDataToCreateJobException::class);
        $this->validator->validate($job);
    }

    public function testWithoutSalaryException()
    {
        $job = $this->factory->make([
            'title' => 'test title',
            'description' => 'desc test',
            'status' => JobInterface::STATUS_VISIBLE,
        ]);

        $this->expectException(InvalidDataToCreateJobException::class);
        $this->validator->validate($job);
    }

    public function testWithoutStatusException()
    {
        $job = $this->factory->make([
            'title' => 'test title',
            'description' => 'desc test',
            'salary' => 3333,
        ]);

        $this->expectException(InvalidDataToCreateJobException::class);
        $this->validator->validate($job);
    }
}