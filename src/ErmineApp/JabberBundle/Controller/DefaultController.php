<?php

namespace ErmineApp\JabberBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ErmineAppJabberBundle:Default:index.html.twig', array('name' => $name));
    }
}
