<?php

namespace ErmineApp\ResponseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ErmineAppResponseBundle:Default:index.html.twig', array('name' => $name));
    }
}
