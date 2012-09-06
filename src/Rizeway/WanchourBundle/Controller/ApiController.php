<?php

namespace Rizeway\WanchourBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Rizeway\WanchourBundle\Utils\AnchourJobCreator;

class ApiController extends BaseController
{
    public function deployAction($repository_id, $command_name, $distribution_id = null)
    {
        $repository = $this->getRepository($repository_id);
        $distribution = is_null($distribution_id) ? null : $this->getDistribution($distribution_id);

        $job_creator = new AnchourJobCreator();
        $job = $job_creator->create($repository, $command_name, $distribution);
        $this->getDoctrine()->getEntityManager()->persist($job);
        $this->getDoctrine()->getEntityManager()->flush();

        return new Response(json_encode(array('status' => 'ok', 'job_id' => $job->getId())));
    }

    public function jobAction($job_id)
    {
        $job = $this->getJob($job_id);
        $logs = array();
        foreach ($job->getLogs() as $job_log) {
            $logs[] = array('priority' => $job_log->getPriorityLabel(), 'message' => $job_log->getMessage());
        }

        return new Response(json_encode(array('status' => $job->getStatusLabel(), 'logs' => $logs)));
    }

    public function repositoriesAction()
    {
        $repositories = $this->getDoctrine()->getEntityManager()->getRepository('RizewayWanchourBundle:Repository')->findAll();
        $result = array();
        foreach ($repositories as $repository) {
            $result[] = array(
                'id'   => $repository->getId(),
                'name' => $repository->getName(),
                'url'  => $repository->getUrl()
            );
        }

        return new Response(json_encode(array('repositories' => $result)));
    }

    public function distributionsAction()
    {
        $distributions = $this->getDoctrine()->getEntityManager()->getRepository('RizewayWanchourBundle:Distribution')->findAll();
        $result = array();
        foreach ($distributions as $distribution) {
            $parameters = array();
            foreach ($distribution->getParameters() as $parameter){
                $parameters[$parameter->getKey()] = $parameter->getValue();
            }

            $result[] = array(
                'id'   => $distribution->getId(),
                'name' => $distribution->getName(),
                'parameters'  => $parameters
            );
        }

        return new Response(json_encode(array('distributions' => $result)));
    }
}
