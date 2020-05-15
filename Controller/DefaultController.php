<?php

namespace Acme\SarbacaneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SarbacaneBundle:Default:index.html.twig');
    }
}
