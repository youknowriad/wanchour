<?php

namespace Rizeway\WanchourBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Rizeway\WanchourBundle\Form\DistributionForm;
use Rizeway\WanchourBundle\Entity\Distribution;
use Rizeway\WanchourBundle\Entity\Parameter;

class DistributionController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('distribution_list'));
    }

    public function listAction($page = 1)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $distributions = $em->getRepository('RizewayWanchourBundle:Distribution')->findAll();

        return $this->render('RizewayWanchourBundle:Distribution:list.html.twig', array(
              'distributions'      => $distributions,
        ));
    }

    public function newAction()
    {
        $distribution = new Distribution();
        $distribution->addParameter(new Parameter());

        $form = $this->get('form.factory')->create(new DistributionForm(), $distribution);

        if ('POST' === $this->get('request')->getMethod()) {
        
            $form->bindRequest($this->get('request'));
            
            if ($form->isValid()) {
        
                // Save the distribution
                $this->get('doctrine.orm.entity_manager')->persist($distribution);
                $this->get('doctrine.orm.entity_manager')->flush();
                
                $this->get('session')->setFlash('success', 'The distribution has been successfully created');

                return new RedirectResponse($this->generateUrl('distribution_edit', array('id' => $distribution->getId())));
            }
        }

        return $this->render('RizewayWanchourBundle:Distribution:new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $distribution = $this->getDistribution($id);
        $form = $this->get('form.factory')->create(new DistributionForm(), $distribution);
        foreach ($distribution->getParameters() as $parameter) $originalParameters[] = $parameter;
        
        if ('POST' === $this->get('request')->getMethod()) {
            $form->bindRequest($this->get('request'));
            if ($form->isValid()) {

                foreach ($distribution->getParameters() as $parameter) {
                    foreach ($originalParameters as $key => $toDel) {
                        if ($toDel->getId() === $parameter->getId()) {
                            unset($originalParameters[$key]);
                        }
                    }
                }

                foreach ($originalParameters as $parameter) {
                    $em->remove($parameter);
                }

                // Save the distribution
                $em->flush();
                $this->get('session')->setFlash('info', 'Your changes has been saved');
                return new RedirectResponse($this->generateUrl('distribution_edit', array('id' => $distribution->getId())));
            }
        }
        
        return $this->render('RizewayWanchourBundle:Distribution:edit.html.twig', array(
            'form' => $form->createView(),
            'distribution' => $distribution
        ));
        
    }
    
    public function deleteAction($id)
    {
        $distribution = $this->getDistribution($id);
        $name = $distribution->getName();
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($distribution);
        $em->flush();

        $this->get('session')->setFlash('success', 'The distribution "'.$name.'" has been deleted !');
        
        return new RedirectResponse($this->generateUrl('distribution_list'));
    }
}
