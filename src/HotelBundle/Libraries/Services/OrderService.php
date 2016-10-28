<?php

namespace HotelBundle\Libraries\Services;

use CoreBundle\Entity\Client;
use CoreBundle\Entity\Order;
use CoreBundle\Entity\Room;

/**
 * Service all order actions.
 *
 * @package HotelBundle\Libraries\Services
 */
class OrderService {

    /**
     * @var CreateOrderService
     */
    private $createOrderService;

    /**
     * @var DeleteOrderService
     */
    private $deleteOrderService;

    /**
     * CreateOrderService constructor.
     *
     * @param CreateOrderService $createOrderService
     * @param DeleteOrderService $deleteOrderService
     */
    public function __construct(CreateOrderService $createOrderService, DeleteOrderService $deleteOrderService) {
        $this->createOrderService = $createOrderService;
        $this->deleteOrderService = $deleteOrderService;
    }

    /**
     * @see CreateOrderService#createOrder
     *
     * @param Client $client
     * @param Room $room
     * @param array $data
     * @return boolean
     */
    public function createOrder(Client $client, Room $room, array $data) {
        return $this->createOrderService->createOrder($client, $room, $data);
    }

    /**
     * @see DeleteOrderService#deleteOrderIfPossible
     *
     * @param Order $order
     * @return boolean
     */
    public function deleteOrderIfPossible(Order $order) {
        return $this->deleteOrderService->deleteOrderIfPossible($order);
    }
}