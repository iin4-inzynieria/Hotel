<?php

namespace HotelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use HotelBundle\Form\StepOneType;
use Symfony\Component\HttpFoundation\Request;

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

    /**
     * Contact page
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contactAction() {

        return $this->render('HotelBundle:Contact:index.html.twig');
    }

    /**
     * Sending contact message
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendMessageAction(Request $request) {

        $contactFormData = $request->request->all();

        $this->addFlash('notice', 'Wiadomość została wysłana!');
        return $this->redirectToRoute('hotel_contact');

    }
}
