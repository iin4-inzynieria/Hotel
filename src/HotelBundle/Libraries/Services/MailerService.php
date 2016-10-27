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
     * @var string
     */
    private $email;

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
     *
     * @param \Twig_Environment $twig
     * @param \Swift_Mailer $mailer
     * @param string $email
     */
    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer, $email) {
        $this->twig = $twig;
        $this->mailer = $mailer;
        $this->email = $email;
    }

    /**
     * Sends simple mime message.
     *
     * @param string $from
     * @param string $to
     * @param string $mimeType
     * @param string $body
     * @return bool
     */
    private function sendSimpleMimeMessage($from, $to, $mimeType, $body) {

        try {
            $message = \Swift_Message::newInstance()
                ->setSubject('Rezerwacja w naszym hotelu.')
                ->setFrom($from)
                ->setTo($to)
                ->setBody($body, $mimeType);

            $this->mailer->send($message);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Sends contact form inquiry.
     *
     * @param array $data
     * @return bool
     */
    public function sendContactEmail(array $data) {

        return $this->sendSimpleMimeMessage($this->email, $this->email, 'text/html',
            $this->twig->render(
                'HotelBundle:Mailer:contact_template.html.twig',
                array('data' => $data)
            )
        );
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

        return $this->sendSimpleMimeMessage($this->email, $client->getEmail(), 'text/html',
            $this->twig->render(
                'HotelBundle:Mailer:reservation_template.html.twig',
                array(
                    'room' => $room,
                    'client' => $client,
                    'data' => $data
                )
            ));
    }
}
