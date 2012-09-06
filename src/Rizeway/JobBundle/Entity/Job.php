<?php

namespace Rizeway\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rizeway\JobBundle\Entity\Job
 */
class Job
{

    const STATUS_NEW = 0;
    const STATUS_RUNNING = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ERROR = 3;

    public static $status_labels = array(
        self::STATUS_NEW => 'new',
        self::STATUS_RUNNING => 'running',
        self::STATUS_SUCCESS => 'success',
        self::STATUS_ERROR => 'error',
    );

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var smallint $status
     */
    private $status = self::STATUS_NEW;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var string $classname
     */
    private $classname;

    /**
     * @var text $options
     */
    private $options;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $logs;

    public function __construct()
    {
        $this->logs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->created_at = new \DateTime();
        $this->setOptions(array());
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Job
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Job
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param smallint $status
     * @return Job
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return smallint 
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function getStatusLabel()
    {
        return self::$status_labels[$this->status];
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Job
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set classname
     *
     * @param string $classname
     * @return Job
     */
    public function setClassname($classname)
    {
        $this->classname = $classname;
        return $this;
    }

    /**
     * Get classname
     *
     * @return string 
     */
    public function getClassname()
    {
        return $this->classname;
    }

    /**
     * Set options
     *
     * @param text $options
     * @return Job
     */
    public function setOptions(array $options)
    {
        $this->options = \json_encode($options);
        return $this;
    }

    /**
     * Get options
     *
     * @return text 
     */
    public function getOptions()
    {
        return json_decode($this->options, true);
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return Job
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
        return $this;
    }

    /**
     * Get created_at
     *
     * @return datetime 
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Add logs
     *
     * @param Rizeway\JobBundle\Entity\JobLog $logs
     * @return Job
     */
    public function addJobLog(\Rizeway\JobBundle\Entity\JobLog $logs)
    {
        $this->logs[] = $logs;
        return $this;
    }

    /**
     * Get logs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getLogs()
    {
        return $this->logs;
    }
}