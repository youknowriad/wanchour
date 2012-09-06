<?php

namespace Rizeway\JobBundle\JobHandler;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class ContainerAwareJobHandler extends JobHandler implements ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function getContainer()
    {
        return $this->container;
    }
}