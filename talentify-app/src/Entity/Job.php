<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/** 
 * @ORM\Entity
 * @ORM\Table(name="tb_job")
 */
class Job implements JobInterface
{
    /**
     * @var null|int
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var null|string
     * @ORM\Column(length=256)
     */
    private $title;

    /**
     * @var null|string
     * @ORM\Column(length=10000)
     */
    private $description;

    /**
     * @var null|string
     * @ORM\Column(type="string", columnDefinition="ENUM('visible', 'invisible')")
     */
    private $status; // Doctrine does not map the MySQL enum type to a Doctrine type. So we map MySQL enum type to string doctrine type manually.

    /** 
     * @var null|array
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $workplace;

    /**
     * @var null|float
     * @ORM\Column(type="decimal",precision=10,scale=2)
     */
    private $salary;

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of title
     *
     * @return  null|string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  null|string  $title
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return  null|string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  null|string  $description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return  null|string
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param  null|string  $status
     * @return  self
     * @throws \InvalidArgumentException
     */ 
    public function setStatus(string $status)
    {
        $validvalues = [
            JobInterface::STATUS_VISIBLE,
            JobInterface::STATUS_INVISIBLE,
        ];

        if (!in_array($status, $validvalues)) {
            throw new \InvalidArgumentException(sprintf('The status [%s] is not valid.', $status));
        }

        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of workplace
     *
     * @return  null|array
     */ 
    public function getWorkplace()
    {
        return $this->workplace;
    }

    /**
     * Set the value of workplace
     *
     * @param  null|array  $workplace
     *
     * @return  self
     */ 
    public function setWorkplace(array $workplace)
    {
        $this->workplace = $workplace;

        return $this;
    }

    /**
     * Get the value of salary
     *
     * @return  null|float
     */ 
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * Set the value of salary
     *
     * @param  null|float  $salary
     *
     * @return  self
     */ 
    public function setSalary(float $salary)
    {
        $this->salary = $salary;

        return $this;
    }
}