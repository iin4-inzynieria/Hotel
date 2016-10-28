<?php

namespace HotelBundle\Libraries\Services;
use CoreBundle\Entity\Order;
use CoreBundle\Entity\Room;
use CoreBundle\Entity\Client;

/**
 * Abstract mailer.
 *
 * @package HotelBundle\Libraries\Services
 */
abstract class AbstractMailer {

    /**
     * The email to send messages from.
     *
     * @var string
     */
    protected $serviceEmail;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * Sends message.
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string $mimeType
     * @return boolean
     */
    protected function send($to, $subject, $body, $mimeType = 'text/html') {

        try {
            $message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($this->serviceEmail)
                ->setTo($to)
                ->setBody($body, $mimeType);

            $this->mailer->send($message);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * @param string $template
     * @param array $params
     * @param string $to
     * @param string $subject
     * @param string $mimeType
     * @return boolean
     */
    protected function renderAndSend($template, array $params, $to, $subject, $mimeType = 'text/html') {
        return $this->send($to, $subject, $this->renderTemplate($template, $params), $mimeType);
    }

    /**
     * Renders given template.
     *
     * @param string $template
     * @param array $params
     * @return string
     */
    private function renderTemplate($template, array $params) {
        return $this->twig->render($template, $params);
    }

    /**
     * Sends contact form inquiry.
     *
     * @param array $data
     * @return boolean
     */
    public abstract function sendContactEmail(array $data);

    /**
     * Sends reservation confirmation message.
     *
     * @param Client $client
     * @param Room $room
     * @param array $data
     * @return boolean
     */
    public abstract function sendReservationEmail(Client $client, Room $room, array $data);

    /**
     * Sends reservation cancellation message.
     *
     * @param Order $order
     * @param Client $client
     * @param Room $room
     * @return boolean
     */
    public abstract function sendReservationCancelledEmail(Order $order, Client $client, Room $room);
}