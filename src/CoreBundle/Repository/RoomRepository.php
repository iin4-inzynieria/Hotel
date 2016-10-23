<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RoomRepository extends EntityRepository
{
    public function getAvailableByDatePeriod(\DateTime $arrival, \DateTime $departure)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('r');

        return [];
    }
}