<?php

namespace HotelBundle\Controller;

use CoreBundle\Entity\Client;
use HotelBundle\Form\StepTwoType;
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
     * @return Response
     */
    public function filterAction(Request $request) {

        $data = $request->request->get('step_one');

        $arrival = new \DateTime($data['arrival']);
        $departure = new \DateTime($data['departure']);

        $entities = $this->getDoctrine()->getRepository('CoreBundle:Room')->getAvailableByDatePeriod($arrival, $departure);

        return $this->render('HotelBundle:Reservation:list_available_rooms.html.twig', array(
            'rooms' => $entities,
            'current' => 'reservation',
            'arrival' => $arrival,
            'departure' => $departure
        ));
    }

    /**
     * Action that renders booking form (StepTwoType).
     *
     * @param Request $request
     * @return Response
     */
    public function bookAction(Request $request) {

        $roomId = $request->attributes->get('id');
        $arrival = new \DateTime($request->request->get('arrival'));
        $departure = new \DateTime($request->request->get('departure'));

        $stepTwoForm = $this->createReservationForm(new Client());

        return $this->render('HotelBundle:Reservation:reservation_form.html.twig', array(
            'form' => $stepTwoForm->createView(),
            'current' => 'reservation',
            'arrival' => $arrival,
            'departure' => $departure,
            'roomId' => $roomId
        ));
    }

    /**
     * Returns SteTwoType form template.
     *
     * @param Client $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createReservationForm(Client $entity) {
        return $this->createForm(StepTwoType::class, $entity, array(
            'action' => $this->generateUrl('hotel_create_reservation'),
            'method' => 'POST'
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createReservationAction(Request $request) {

        $client = new Client();
        $form = $this->createReservationForm($client);
        $form->handleRequest($request);

        $postParams = $request->request->get('step_two');
        $dates = array(
            'arrival' => new \DateTime($postParams['arrival']),
            'departure' => new \DateTime($postParams['departure'])
        );

        $room = $this->getDoctrine()->getRepository('CoreBundle:Room')->findOneBy(array('id' => $postParams['roomId']));

        $successful = $this->container->get('hotel_create_order_service')->createOrder($client, $room, $dates);

        if($successful) {
            $this->addFlash('notice', 'Pokój został zarezerwowany.');
        } else {
            $this->addFlash('error', 'Coś poszło nie tak, pokój nie został zarezerwowany.');
        }

        return $this->redirect($this->generateUrl('hotel_homepage'));
    }
}
