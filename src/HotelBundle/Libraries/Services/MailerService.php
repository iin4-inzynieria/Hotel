<?php

namespace HotelBundle\Libraries\Services;

use CoreBundle\Entity\Client;
use CoreBundle\Entity\Room;

/**
 * Service responsible for sending emails.
 *
 * @package HotelBundle\Libraries\Services
 */
class MailerService {

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * MailerService constructor.
     * @param \Twig_Environment $twig
     * @param \Swift_Mailer $mailer
     */
    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer) {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    /**
     * Sends reservation confirmation message.
     *
     * @param Client $client
     * @param Room $room
     * @param array $data
     * @return boolean;
     */
    public function sendReservationEmail(Client $client, Room $room, array $data) {

        try {
            $message = \Swift_Message::newInstance()
                ->setSubject('Rezerwacja w naszym hotelu.')
                ->setFrom('hoteljanusz@gmail.com')
                ->setTo($client->getEmail())
                ->setBody(
                    $this->twig->render(
                        'HotelBundle:Mailer:reservation_template.html.twig',
                        array(
                            'room' => $room,
                            'client' => $client,
                            'data' => $data
                        )
                    ),
                    'text/html'
                );

            $this->mailer->send($message);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
