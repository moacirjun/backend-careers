<?php

namespace App\Tests\Entity;

use App\Entity\Job;
use App\Entity\JobInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class JobTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $job = new Job();
        $job->setTitle('title');
        $job->setDescription('description');
        $job->setStatus('invisible');
        $job->setWorkplace(['postcode' => 12312312, 'number' => 123]);
        $job->setSalary(3500.55);

        $this->assertEquals('title', $job->getTitle());
        $this->assertEquals('title', $job->getTitle());
        $this->assertEquals('description', $job->getDescription());
        $this->assertEquals('invisible', $job->getStatus());
        $this->assertEquals(['postcode' => 12312312, 'number' => 123], $job->getWorkplace());
        $this->assertEquals(3500.55, $job->getSalary());
    }

    public function testStatusValueValidation()
    {
        $job = new Job();

        $job->setStatus(JobInterface::STATUS_VISIBLE);
        $this->assertEquals(JobInterface::STATUS_VISIBLE, $job->getStatus());

        $job->setStatus(JobInterface::STATUS_INVISIBLE);
        $this->assertEquals(JobInterface::STATUS_INVISIBLE, $job->getStatus());

        $this->expectException(\InvalidArgumentException::class);
        $job->setStatus('INVALID STATUS VALUE');
    }
}