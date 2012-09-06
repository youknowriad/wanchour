<?php

namespace Rizeway\WanchourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rizeway\WanchourBundle\Entity\Repository
 */
class Repository
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $url
     */
    private $url;

    /**
     * @var boolean $deploying
     */
    private $deploying = false;



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
     * @return Repository
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
     * Set url
     *
     * @param string $url
     * @return Repository
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set deploying
     *
     * @param boolean $deploying
     * @return Repository
     */
    public function setDeploying($deploying)
    {
        $this->deploying = $deploying;
        return $this;
    }

    /**
     * Get deploying
     *
     * @return boolean 
     */
    public function getDeploying()
    {
        return $this->deploying;
    }
    /**
     * @var array $commands
     */
    private $commands;


    /**
     * Set commands
     *
     * @param array $commands
     * @return Repository
     */
    public function setCommands($commands)
    {
        $this->commands = $commands;
        return $this;
    }

    /**
     * Get commands
     *
     * @return array 
     */
    public function getCommands()
    {
        return $this->commands;
    }
}