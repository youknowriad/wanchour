<?php

namespace Rizeway\WanchourBundle\Utils;

use Rizeway\JobBundle\Entity\Job;

class AnchourJobCreator
{
    public function create($repository, $command_name, $distribution = null)
    {
        $job = new Job();
        $job->setName('Command : '.$repository->getName(). ' > '.$command_name);
        $job->setType('anchour.rep-'.$repository->getId().'.command');
        $job->setClassname('\Rizeway\WanchourBundle\JobHandler\LaunchCommandJobHandler');
        $job->setOptions(array(
            'repository'   => $repository->getId(),
            'command_name' => $command_name,
            'distribution' => is_null($distribution) ? null : $distribution->getId()
        ));

        return $job;
    }
}