<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HotelBundle\Form\StepOneType;

class DefaultController extends Controller {

    /**
     * Default index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction() {

        $stepOneForm = $this->createForm(StepOneType::class, [], [
            'action' => $this->generateUrl('hotel_filter'),
            'method' => 'POST'
        ]);

        return $this->render('HotelBundle:Index:index.html.twig', [
            'form' => $stepOneForm->createView()
        ]);
    }
}
