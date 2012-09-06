<?php

namespace Rizeway\WanchourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rizeway\WanchourBundle\Entity\Distribution
 */
class Distribution
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
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $parameters;

    public function __construct()
    {
        $this->parameters = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Distribution
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
     * Add parameters
     *
     * @param Rizeway\WanchourBundle\Entity\Parameter $parameters
     * @return Distribution
     */
    public function addParameter(\Rizeway\WanchourBundle\Entity\Parameter $parameters)
    {
        $parameters->setDistribution($this);
        $this->parameters[] = $parameters;
        return $this;
    }

    /**
     * Remove parameters
     *
     * @param Rizeway\WanchourBundle\Entity\Parameter $parameters
     * @return Distribution
     */
    public function removeParameter(\Rizeway\WanchourBundle\Entity\Parameter $parameters)
    {
        foreach ($this->parameters as $key => $param) {
            if ($param->getKey() == $parameters->getKey()) {
                unset($this->parameters[$key]);
            }
        }
        return $this;
    }

    /**
     * Get parameters
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * string description 
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}