<?php

namespace ErmineApp\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ErmineApp\UserBundle\Form\Type\RegistrationType;
use ErmineApp\UserBundle\Form\Model\Registration;
use Symfony\Component\HttpFoundation\Request;

class AccountController extends Controller
{
    public function registerAction()
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
            'action' => $this->generateUrl('account_create'),
        ));

        return $this->render(
            'ErmineAppUserBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }


    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new RegistrationType(), new Registration());
        $form->handleRequest($request);
        if ($form->isValid()) {
            $registration = $form->getData();

            $user = $registration->getUser();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $name = 'test';
            $user
                ->setPassword($encoded)
                ->setRole('ROLE_USER')
                ->setName($name)
                ->setStatus('1')
                ->setFbid('')
                ->setCreated(new \DateTime('now'))
                ->setLogin('1')
                ->setStatus('1')
                ->setLanStatus('1')
                ->setIsOnline('0')
            ;

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render(
            'ErmineAppUserBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }
}