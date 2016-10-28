<?php

namespace HotelBundle\Controller;

use CoreBundle\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RoomController extends Controller {

    /**
     * Default room index action. Lists all rooms.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {

        $rooms = $this->getDoctrine()->getRepository('CoreBundle:Room')->findAllWithPrices();

        return $this->render('HotelBundle:Room:index.html.twig', [
            'rooms' => $rooms,
            'current' => 'offer'
        ]);
    }

    /**
     * Room show action. Shows details about
     * particular room.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id) {

        $roomRepository = $this->getDoctrine()->getRepository('CoreBundle:Room');
        $room = $roomRepository->find($id);

        if ($room instanceof Room) {

            $roomPrice = $roomRepository->getRoomPrice($room);

            return $this->render('HotelBundle:Room:show.html.twig', [
                'room' => $room,
                'roomPrice' => $roomPrice
            ]);
        }

        return $this->redirectToRoute('hotel_homepage');

    }
}
