<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HotelBundle\Form\StepOneType;
use Symfony\Component\HttpFoundation\Request;

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

}
