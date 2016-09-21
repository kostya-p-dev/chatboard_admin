<?php

namespace ErmineApp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * @Route("/register/test", name="test")
     */
    public function updateInterestsAction()
    {
        return $this->render('ErmineAppUserBundle:Default:test.html.twig');
    }

    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        if (!$this->getUser() || $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN')) {
            return $this->redirect($this->generateUrl('sonata_admin_dashboard'));
        }
        throw $this->createNotFoundException('Not Found');
    }
}
