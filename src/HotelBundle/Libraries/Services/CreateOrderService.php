<?php

namespace HotelBundle\Libraries\Services;

use CoreBundle\Entity\Client;
use CoreBundle\Entity\Order;
use CoreBundle\Entity\Room;
use Doctrine\ORM\EntityManager;

/**
 * Service responsible for creating orders.
 *
 * @package HotelBundle\Libraries\Services
 */
class CreateOrderService {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CreateOrderService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * @param Client $client
     * @param Room $room
     * @param array $data
     * @return Order
     */
    public function createOrder(Client $client, Room $room, array $data) {

        try {
            $order = new Order();
            $order->setClient($client);
            $order->setRoom($room);
            $order->setArrival($data['arrival']);
            $order->setDeparture($data['departure']);

            $this->em->persist($order);
            $this->em->flush();

            $this->em->getRepository('CoreBundle:Calendar')->changeStatusBetween(
                0,
                $data['arrival'],
                $data['departure'],
                $room
            );
        } catch(\Exception $e) {
            return false;
        }

        return true;
    }
}