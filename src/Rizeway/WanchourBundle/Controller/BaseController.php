<?php

namespace Rizeway\WanchourBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

abstract class BaseController extends Controller
{    
    protected function getDistribution($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $distribution = $em->getRepository('RizewayWanchourBundle:Distribution')->find($id);
        if (!$distribution) {
            throw new NotFoundHttpException(sprintf('The distribution %s was not found', $id));
        }

        return $distribution;
    }

    protected function getRepository($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $em->getRepository('RizewayWanchourBundle:Repository')->find($id);
        if (!$repository) {
            throw new NotFoundHttpException(sprintf('The repository %s was not found', $id));
        }

        return $repository;
    }

    protected function getJob($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $job = $em->getRepository('RizewayJobBundle:Job')->find($id);
        if (!$job) {
            throw new NotFoundHttpException(sprintf('The job %s was not found', $id));
        }

        return $job;
    }
}
