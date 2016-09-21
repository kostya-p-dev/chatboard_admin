<?php

namespace ErmineApp\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class AjaxController extends Controller
{
    /**
     * @Route("/ajaxtimehelper", name="ajax_time_helper")
     * @Method("POST")
     */
    public function ajaxTimeHelperAction(Request $request)
    {

        $date = $request->request->get('date');
        $hour = $request->request->get('hour');

        $date = new \DateTime($date);
        $date->modify($hour);
        $date = $date->format('h:i A');

        return new JsonResponse(array('date' => $date));
    }
}
