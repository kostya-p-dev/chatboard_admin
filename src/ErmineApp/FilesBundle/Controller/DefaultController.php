<?php

namespace ErmineApp\FilesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ErmineAppFilesBundle:Default:index.html.twig', array('name' => $name));
    }
}
