<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HotelBundle\Form\StepOneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller {

    /**
     * Renders reservation page.
     *
     * @return Response
     */
    public function indexAction() {

        $stepOneForm = $this->createForm(StepOneType::class, [], [
            'action' => $this->generateUrl('hotel_filter'),
            'method' => 'POST'
        ]);

        return $this->render('HotelBundle:Reservation:index.html.twig', [
            'form' => $stepOneForm->createView(),
            'current' => 'reservation'
        ]);
    }

    /**
     * Renders list room view. Lists only rooms that are matching given
     * criteria (eg. only available rooms).
     *
     * @param Request $request
     *
     * @return Response
     */
    public function filterAction(Request $request) {

        $data = $request->request->get('step_one');

        $arrival = new \DateTime($data['arrival']);
        $departure = new \DateTime($data['departure']);

        $entities = $this->getDoctrine()->getRepository('CoreBundle:Room')->getAvailableByDatePeriod($arrival, $departure);

        return $this->render('HotelBundle:Reservation:list_available_rooms.html.twig', array(
            'rooms' => $entities,
            'current' => 'reservation'
        ));
    }
}
