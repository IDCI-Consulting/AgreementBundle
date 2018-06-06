<?php

namespace IDCI\Bundle\AgreementBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use IDCI\Bundle\AgreementBundle\Exception\ContractingPartyNotAgreeTermException;
use IDCI\Bundle\AgreementBundle\Exception\NoValidAgreementException;
use IDCI\Bundle\AgreementBundle\Exception\UndefinedTermException;
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

    public function createAgreement(ContractingPartyInterface $contractingParty, $termReference)
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

    public function getLastAgreement(ContractingPartyInterface $contractingParty, $termReference)
    {
        $lastAgreement = $this->om->getRepository(Agreement::class)->findLastByTermReference($contractingParty, $termReference);

        if (null === $lastAgreement) {
            throw new ContractingPartyNotAgreeTermException(sprintf('The contracting party "%s" not agree the term "%s"', $contractingParty->getUuid(), $termReference));
        }

        return $lastAgreement;
    }

    public function getCurrentTerm($termReference)
    {
        $currentTerm = $this->om->getRepository(Term::class)->findCurrent($termReference);

        if (null === $currentTerm) {
            throw new UndefinedTermException(sprintf('The term is undefined "%s"', $termReference));
        }

        return $currentTerm;
    }

    public function getValidAgreement(ContractingPartyInterface $contractingParty, $termReference)
    {
        $currentTerm = $this->getCurrentTerm($termReference);
        $lastAgreement = $this->getLastAgreement($contractingParty, $termReference);

        if ($lastAgreement->getTerm() !== $currentTerm) {
            throw new NoValidAgreementException(sprintf('The contracting party "%s" do not have valid agreement for the term "%s"', $contractingParty->getUuid(), $termReference));
        }

        return $lastAgreement;
    }
}
