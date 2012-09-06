<?php

namespace Rizeway\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Rizeway\JobBundle\Logger\LoggerInterface;

/**
 * Rizeway\JobBundle\Entity\JobLog
 */
class JobLog
{
    public static $priority_labels = array(
        LoggerInterface::PRIORITY_INFO => 'info',
        LoggerInterface::PRIORITY_WARNING => 'warning',
        LoggerInterface::PRIORITY_ERROR => 'error',
    );

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var text $message
     */
    private $message;

    /**
     * @var smallint $priority
     */
    private $priority;

    /**
     * @var datetime $created_at
     */
    private $created_at;

    /**
     * @var Rizeway\JobBundle\Entity\Job
     */
    private $job;

    public function __construct()
    {
        $this->created_at = new \DateTime();
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
     * Set message
     *
     * @param text $message
     * @return JobLog
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     *
     * @return text 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set priority
     *
     * @param smallint $priority
     * @return JobLog
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * Get priority
     *
     * @return smallint 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    public function getPriorityLabel()
    {
        return self::$priority_labels[$this->priority];
    }

    /**
     * Set created_at
     *
     * @param datetime $createdAt
     * @return JobLog
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
     * Set job
     *
     * @param Rizeway\JobBundle\Entity\Job $job
     * @return JobLog
     */
    public function setJob(\Rizeway\JobBundle\Entity\Job $job = null)
    {
        $this->job = $job;
        return $this;
    }

    /**
     * Get job
     *
     * @return Rizeway\JobBundle\Entity\Job 
     */
    public function getJob()
    {
        return $this->job;
    }
}