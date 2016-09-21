<?php

namespace ErmineApp\SocialNetsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ErmineAppSocialNetsBundle:Default:index.html.twig', array('name' => $name));
    }
}
