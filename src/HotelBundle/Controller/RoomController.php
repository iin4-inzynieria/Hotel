<?php

namespace HotelBundle\Controller;

use CoreBundle\Entity\Room;
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

    public function showAction($id){
        $roomRepository = $this->getDoctrine()->getRepository('CoreBundle:Room');
        $room = $roomRepository->find($id);

        if($room instanceof Room){

            $roomPrice = $roomRepository->getActualRoomPrice($room);

            return $this->render('HotelBundle:Room:show.html.twig', [
                'room' => $room,
                'roomPrice' => $roomPrice
            ]);
        }

        return $this->redirectToRoute('hotel_homepage');


    }
}
