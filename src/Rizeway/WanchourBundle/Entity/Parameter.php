<?php

namespace Rizeway\WanchourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rizeway\WanchourBundle\Entity\Parameter
 */
class Parameter
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $key
     */
    private $key;

    /**
     * @var string $value
     */
    private $value;


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
     * Set key
     *
     * @param string $key
     * @return Parameter
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Parameter
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }
    /**
     * @var Rizeway\WanchourBundle\Entity\Distribution
     */
    private $distribution;


    /**
     * Set distribution
     *
     * @param Rizeway\WanchourBundle\Entity\Distribution $distribution
     * @return Parameter
     */
    public function setDistribution(\Rizeway\WanchourBundle\Entity\Distribution $distribution = null)
    {
        $this->distribution = $distribution;
        return $this;
    }

    /**
     * Get distribution
     *
     * @return Rizeway\WanchourBundle\Entity\Distribution 
     */
    public function getDistribution()
    {
        return $this->distribution;
    }
}