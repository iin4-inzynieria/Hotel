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
}