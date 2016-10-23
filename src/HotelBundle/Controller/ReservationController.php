<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HotelBundle\Form\StepOneType;
use Symfony\Component\HttpFoundation\Request;

class ReservationController extends Controller
{
    public function indexAction()
    {
        $stepOneForm = $this->createForm(StepOneType::class, [], [
            'action' => $this->generateUrl('hotel_filter'),
            'method' => 'POST'
        ]);

        return $this->render('HotelBundle:Reservation:index.html.twig', [
            'form' => $stepOneForm->createView(),
            'current' => 'reservation'
        ]);
    }

    public function checkAction(Request $request)
    {
        $data = $request->request->get('step_one');

        $arrival = new \DateTime($data['arrival']);
        $departure = new \DateTime($data['departure']);

        $entities = $this->getDoctrine()->getRepository('CoreBundle:Room')->getAvailableByDatePeriod($arrival, $departure);

    }
}
