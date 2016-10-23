<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HotelBundle\Form\StepOneType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $stepOneForm = $this->createForm(StepOneType::class, [], [
            'action' => $this->generateUrl('hotel_check'),
            'method' => 'POST'
        ]);

        return $this->render('HotelBundle:Index:index.html.twig', [
            'form' => $stepOneForm->createView()
        ]);
    }

    public function checkAction(Request $request)
    {
        $data = $request->request->get('step_one');

        $arrival = new \DateTime($data['arrival']);
        $departure = new \DateTime($data['departure']);

        return new Response(':)');
        //dump($arrival, $departure); die;
    }
}
