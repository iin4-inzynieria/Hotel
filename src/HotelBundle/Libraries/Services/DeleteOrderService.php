<?php

namespace HotelBundle\Libraries\Services;

use CoreBundle\Entity\Order;
use Doctrine\ORM\EntityManager;

/**
 * Service responsible for deleting orders.
 *
 * @package HotelBundle\Libraries\Services
 */
class DeleteOrderService {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var MailerService
     */
    private $mailer;

    /**
     * CreateOrderService constructor.
     *
     * @param EntityManager $em
     * @param MailerService $mailer
     */
    public function __construct(EntityManager $em, MailerService $mailer) {
        $this->em = $em;
        $this->mailer = $mailer;
    }

    /**
     * Removes order from database.
     *
     * @param Order $order
     */
    private function delete(Order $order) {
        $this->em->remove($order);
        $this->em->flush();
    }

    /**
     * Deletes given order if all conditions are met (at least
     * 14 days to arrival).
     *
     * @param Order $order
     * @return boolean
     */
    public function deleteOrderIfPossible(Order $order) {

        try {

            $dayDifference = intval((new \DateTime())->diff($order->getDeparture(), true)->format('%a')) + 1;

            if ($dayDifference > 14) {
                $this->delete($order);
                $this->em->getRepository('CoreBundle:Calendar')->changeStatusBetween(1,
                    $order->getArrival(),
                    $order->getDeparture(),
                    $order->getRoom()
                );
                $this->mailer->sendReservationCancelledEmail($order, $order->getClient(), $order->getRoom());
                return true;
            }

            return false;

        } catch (\Exception $e) {
            return false;
        }
    }
}