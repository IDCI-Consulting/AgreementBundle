<?php

namespace IDCI\Bundle\AgreementBundle\Repository\Doctrine;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use IDCI\Bundle\AgreementBundle\Model\Agreement;
use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;
use IDCI\Bundle\AgreementBundle\Repository\AgreementRepositoryInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class DoctrineORMAgreementRepository extends ServiceEntityRepository implements AgreementRepositoryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Agreement::class);
    }

    public function findLastByTermReference(ContractingPartyInterface $contractingParty, string $termReference): ?Agreement
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->andWhere('a.contractingPartyUuid = :contractingPartyUuid')
            ->join('a.term', 't')
            ->andWhere('t.reference = :termReference')
            ->setParameter('contractingPartyUuid', $contractingParty->getUuid())
            ->setParameter('termReference', $termReference)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
        ;

        return $qb->getOneOrNullResult();
    }
}
