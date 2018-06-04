<?php

namespace IDCI\Bundle\AgreementBundle\Repository\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use IDCI\Bundle\AgreementBundle\Model\Term;
use IDCI\Bundle\AgreementBundle\Repository\TermRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineORMTermRepository extends ServiceEntityRepository implements TermRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Term::class);
    }

    public function findCurrent(string $reference): ?Term
    {
        $qb = $this
            ->createQueryBuilder('t')
            ->andWhere('t.reference = :reference')
            ->andWhere('t.applicableAt < :nowDate')
            ->setParameter('reference', $reference)
            ->setParameter('nowDate', new \DateTime('now'))
            ->orderBy('t.applicableAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $qb->getOneOrNullResult();
    }
}
