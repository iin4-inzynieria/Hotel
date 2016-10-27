<?php

namespace CoreBundle\Repository;

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
        
        $interval = $arrival->diff($departure, true)->d + 1;
        
        return $this->createQueryBuilder('r')
            ->select('r')
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
}