<?php

namespace CoreBundle\Repository;

use CoreBundle\Entity\Room;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityRepository;

class CalendarRepository extends EntityRepository {

    /**
     * Sets room status to available or taken between given dates.
     *
     * @param boolean $available
     * @param \DateTime $arrival
     * @param \DateTime $departure
     * @param Room $room
     * @return int
     */
    public function changeStatusBetween($available, \DateTime $arrival, \DateTime $departure, Room $room) {

        return $this->createQueryBuilder('c')
            ->update()
            ->set('c.available', ':available')
            ->where('c.room = :room')
            ->andWhere('c.date BETWEEN :arrival AND :departure')
            ->setParameter('available', $available)
            ->setParameter('room', $room)
            ->setParameter('arrival', $arrival)
            ->setParameter('departure', $departure)
            ->getQuery()
            ->getResult();
    }
}