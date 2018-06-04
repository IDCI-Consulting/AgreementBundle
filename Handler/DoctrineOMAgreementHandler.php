<?php

namespace IDCI\Bundle\AgreementBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use IDCI\Bundle\AgreementBundle\Model\Agreement;
use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;
use IDCI\Bundle\AgreementBundle\Model\Term;

class DoctrineOMAgreementHandler
{
    private $om;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function createAgreement(ContractingPartyInterface $contractingParty, string $termReference): Agreement
    {
        $currentTerm = $this->getCurrentTerm($termReference);

        $agreement = new Agreement();
        $agreement
            ->setContractingPartyUuid($contractingParty->getUuid())
            ->setTerm($currentTerm)
        ;

        $this->om->persist($agreement);
        $this->om->flush();

        return $agreement;
    }

    public function getLastAgreement(ContractingPartyInterface $contractingParty, string $termReference): Agreement
    {
        $lastAgreement = $this->om->getRepository(Agreement::class)->findLastByTermReference($contractingParty, $termReference);

        if (null === $lastAgreement) {
            throw new ContractingPartyNotAgreeTermException($contractingParty, $lastAgreement);
        }

        return $lastAgreement;
    }

    public function getCurrentTerm(string $termReference): Term
    {
        $currentTerm = $this->om->getRepository(Term::class)->findCurrent($termReference);

        if (null === $currentTerm) {
            throw new UndefinedTermException($termReference);
        }

        return $currentTerm;
    }

    public function getValidAgreement(ContractingPartyInterface $contractingParty, string $termReference): Agreement
    {
        $currentTerm = $this->getCurrentTerm($termReference);
        $lastAgreement = $this->getLastAgreement($contractingParty, $termReference);

        if ($lastAgreement->getTerm() !== $currentTerm) {
            throw new NoValidAgreementException($contractingParty, $termReference);
        }

        return $lastAgreement;
    }
}
