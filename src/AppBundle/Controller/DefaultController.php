<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
//    public function indexAction()
//    {
//
//
//
//
//        return $this->render('default/index.html.twig');
//    }

    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        if (!$this->getUser() || $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }else{
            return $this->redirect($this->generateUrl('login_route'));
        }
        throw $this->createNotFoundException('Not Found');
    }
}
