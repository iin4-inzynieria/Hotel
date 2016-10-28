<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\Room;
use Doctrine\ORM\EntityRepository;

class RoomRepository extends EntityRepository {

    /**
     * Returns rooms with prices.
     *
     * @return array
     */
    public function findAllWithPrices() {

        return $this->createQueryBuilder('r')
            ->select('r AS room, c.price as price')
            ->leftJoin('r.calendar', 'c')
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns rooms available between given dates and their prices for given
     * period.
     *
     * @param \DateTime $arrival
     * @param \DateTime $departure
     *
     * @return array
     */
    public function getAvailableByDatePeriod(\DateTime $arrival, \DateTime $departure) {

        $interval = intval($arrival->diff($departure, true)->format('%a')) + 1;

        return $this->createQueryBuilder('r')
            ->select('r AS room, SUM(c.price) AS price')
            ->leftJoin('r.calendar', 'c')
            ->where('c.available = :availability')
            ->andWhere('c.date BETWEEN :arrival AND :departure')
            ->groupBy('c.room')
            ->having('COUNT(c.id) = :interval')
            ->setParameter('arrival', $arrival)
            ->setParameter('departure', $departure)
            ->setParameter('availability', 1)
            ->setParameter('interval', $interval)
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns room price.
     *
     * @param Room $room
     * @return mixed
     */
    public function getRoomPrice(Room $room) {

        $dateNow = new \DateTime();
        return $this->createQueryBuilder('r')
            ->select('c.price')
            ->leftJoin('r.calendar', 'c')
            ->where('r.id = :roomId')
            ->andWhere('c.date = :date')
            ->setParameter('roomId', $room->getId())
            ->setParameter('date', $dateNow->format('Y-m-d'))
            ->getQuery()
            ->getSingleScalarResult();
    }
}