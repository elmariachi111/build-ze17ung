<?php


namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ExcerptRepository extends EntityRepository
{
    public function before($id) {
        $qb = $this->createQueryBuilder('e');
        $qb->where($qb->expr()->lt('e.id', $id));
        return $qb;
    }
}