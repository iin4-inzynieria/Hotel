<?php

namespace HotelBundle\Libraries\Services;

use CoreBundle\Entity\Client;
use CoreBundle\Entity\Order;
use CoreBundle\Entity\Room;

/**
 * Default mailer implementation.
 *
 * @package HotelBundle\Libraries\Services
 */
class MailerService extends AbstractMailer {

    /**
     * MailerService constructor.
     *
     * @param \Twig_Environment $twig
     * @param \Swift_Mailer $mailer
     * @param string $serviceEmail
     */
    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer, $serviceEmail) {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->serviceEmail = $serviceEmail;
    }

    /**
     * {@inheritdoc}
     */
    public function sendContactEmail(array $data) {

        return $this->renderAndSend(
            'HotelBundle:Mailer:contact_template.html.twig',
            array('data' => $data),
            $this->serviceEmail,
            'Zapytanie'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sendReservationEmail(Client $client, Room $room, array $data) {

        return $this->renderAndSend(
            'HotelBundle:Mailer:reservation_template.html.twig',
            array('room' => $room, 'client' => $client, 'data' => $data),
            $client->getEmail(),
            'Rezerwacja w naszym hotelu.'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function sendReservationCancelledEmail(Order $order, Client $client, Room $room) {

        return $this->renderAndSend(
            'HotelBundle:Mailer:cancel_reservation_template.html.twig',
            array('order' => $order, 'client' => $client, 'room' => $room),
            $client->getEmail(),
            'Odwołanie rezerwacji.'
        );
    }
}
