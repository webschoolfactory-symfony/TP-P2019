<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SubjectRepository extends EntityRepository
{
    public function findNotResolved()
    {
        return $this->createQueryBuilder('subject')
            ->where('subject.resolved = false')
            ->orderBy('subject.upVote - subject.downVote', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findResolved()
    {
        return $this->createQueryBuilder('subject')
            ->where('subject.resolved = true')
            ->andWhere('subject.updatedAt > :date')
            ->setParameter('date', new \DateTime('-6 months'))
            ->orderBy('subject.upVote - subject.downVote', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
