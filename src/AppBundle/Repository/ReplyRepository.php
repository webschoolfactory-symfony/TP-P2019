<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Subject;
use Doctrine\ORM\EntityRepository;

class ReplyRepository extends EntityRepository
{
    public function findOrderedBySubject(Subject $subject)
    {
        return $this->createQueryBuilder('reply')
            ->innerJoin('reply.subject', 'subject')
            ->where('reply.subject = :subject')
            ->orderBy('reply.upVote - reply.downVote', 'DESC')
            ->setParameter('subject', $subject)
            ->getQuery()
            ->getResult();
    }
}
