<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoomController extends Controller
{
    public function indexAction()
    {
        $rooms = $this->getDoctrine()->getRepository('CoreBundle:Room')->findAll();

        return $this->render('HotelBundle:Room:index.html.twig', [
            'rooms' => $rooms,
            'current' => 'offer'
        ]);
    }
}
