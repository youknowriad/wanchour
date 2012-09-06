<?php

namespace Rizeway\WanchourBundle\Controller;

class DefaultController extends BaseController
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('repository_list'));
    }
}
