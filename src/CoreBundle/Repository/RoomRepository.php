<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\Room;
use Doctrine\ORM\EntityRepository;

class RoomRepository extends EntityRepository {

    /**
     * Returns rooms available between given dates.
     *
     * @param \DateTime $arrival
     * @param \DateTime $departure
     *
     * @return array
     */
    public function getAvailableByDatePeriod(\DateTime $arrival, \DateTime $departure) {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->where('c.available = :availability')
            ->andWhere('c.date BETWEEN :arrival AND :departure')
            ->setParameter('arrival', $arrival)
            ->setParameter('departure', $departure)
            ->setParameter('availability', 1)
            ->leftJoin('r.calendar', 'c')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param Room $room
     * @return mixed
     */
    public function getActualRoomPrice(Room $room){

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