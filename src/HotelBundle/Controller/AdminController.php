<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function reservationListAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $orders = $em->getRepository('CoreBundle:Order')->findAll();

        return $this->render('HotelBundle:Admin:reservation_list.html.twig', array(
            'orders' => $orders
        ));
    }

}
