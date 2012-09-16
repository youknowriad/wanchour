<?php

namespace Rizeway\WanchourBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Rizeway\WanchourBundle\Form\RepositoryForm;
use Rizeway\WanchourBundle\Entity\Repository;
use Rizeway\WanchourBundle\Utils\CommandLauncher;
use Rizeway\WanchourBundle\Form\SelectDistributionForm;
use Rizeway\WanchourBundle\Utils\AnchourJobCreator;
use Rizeway\JobBundle\Entity\Job;

class RepositoryController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('repository_list'));
    }

    public function listAction($page = 1)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $repositories = $em->getRepository('RizewayWanchourBundle:Repository')->findAll();

        return $this->render('RizewayWanchourBundle:Repository:list.html.twig', array(
              'repositories'      => $repositories,
        ));
    }

    public function newAction()
    {
        $repository = new Repository();
        $form = $this->get('form.factory')->create(new RepositoryForm(), $repository);

        if ('POST' === $this->get('request')->getMethod()) {
        
            $form->bindRequest($this->get('request'));
            
            if ($form->isValid()) {
        
                // Save the repository
                $this->get('doctrine.orm.entity_manager')->persist($repository);
                $this->get('doctrine.orm.entity_manager')->flush();
                
                $this->get('session')->setFlash('success', 'The repository has been successfully created');

                return new RedirectResponse($this->generateUrl('repository_edit', array('id' => $repository->getId())));
            }
        }

        return $this->render('RizewayWanchourBundle:Repository:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $this->getRepository($id);
        $form = $this->get('form.factory')->create(new RepositoryForm(), $repository);
        
        if ('POST' === $this->get('request')->getMethod()) {
            $form->bindRequest($this->get('request'));
            if ($form->isValid()) {
                // Save the repository
                $em->flush();
                $this->get('session')->setFlash('info', 'Your changes has been saved');
                return new RedirectResponse($this->generateUrl('repository_edit', array('id' => $repository->getId())));
            }
        }
        
        return $this->render('RizewayWanchourBundle:Repository:edit.html.twig', array(
            'form' => $form->createView(),
            'repository' => $repository
        ));
    }
    
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $this->getRepository($id);
        $form = $this->get('form.factory')->create(new SelectDistributionForm());
        
        return $this->render('RizewayWanchourBundle:Repository:show.html.twig', array(
            'repository' => $repository,
            'form'       => $form->createView()
        ));
        
    }

    public function deleteAction($id)
    {
        $repository = $this->getRepository($id);
        $name = $repository->getName();
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($repository);
        $em->flush();

        $this->get('session')->setFlash('success', 'The repository "'.$name.'" has been deleted !');
        
        return new RedirectResponse($this->generateUrl('repository_list'));
    }

    public function updateCommandsAction($id)
    {
        $repository = $this->getRepository($id);

        $job = new Job();
        $job->setName('Updating repository commands : '.$repository->getName());
        $job->setType('anchour.rep-'.$repository->getId().'.update');
        $job->setClassname('\Rizeway\WanchourBundle\JobHandler\UpdateCommandsJobHandler');
        $job->setOptions(array(
            'repository'   => $repository->getId()
        ));
        $this->getDoctrine()->getEntityManager()->persist($job);
        $this->getDoctrine()->getEntityManager()->flush();
        $this->get('session')->setFlash('success', 'Job added to Queue!');
        
        return new RedirectResponse($this->generateUrl('repository_list'));
    }

    public function jobsAction($id, $page = 1)
    {
        $jobs_by_page = 30;
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $this->getRepository($id);
        $jobs = $em->createQuery("select j from RizewayJobBundle:Job j where j.type LIKE :type ORDER BY j.created_at DESC")
            ->setParameter('type', 'anchour.rep-'.$repository->getId().'%')
            ->setMaxResults($jobs_by_page)->setFirstResult(($page-1) * $jobs_by_page)
            ->getResult();

        return $this->render('RizewayWanchourBundle:Repository:Job/list.html.twig', array(
            'repository' => $repository,
            'jobs' => $jobs,
            'page' => $page,
            'show_pager' => count($jobs) == $jobs_by_page
        ));
    }

    public function jobLogsAction($id, $job_id)
    {
        $repository = $this->getRepository($id);
        $job = $this->getJob($job_id);
        
        return $this->render('RizewayWanchourBundle:Repository:Job/logs.html.twig', array(
            'repository' => $repository,
            'job' => $job));
    }

    public function launchCommandAction($id, $command_name)
    {
        $repository = $this->getRepository($id);
        $distribution_id = $this->getRequest()->get('distribution', null);
        $distribution = is_null($distribution_id) ? null : $this->getDistribution($distribution_id);

        $job_creator = new AnchourJobCreator();
        $job = $job_creator->create($repository, $command_name, $distribution);
        $this->getDoctrine()->getEntityManager()->persist($job);
        $this->getDoctrine()->getEntityManager()->flush();
        $this->get('session')->setFlash('success', 'Job added to Queue!');
        
        return new RedirectResponse($this->generateUrl('repository_show', array('id' => $repository->getId())));
    }
}
