<?php

namespace IDCI\Bundle\AgreementBundle\Handler;

use IDCI\Bundle\AgreementBundle\Model\Agreement;
use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;
use IDCI\Bundle\AgreementBundle\Model\Term;

interface AgreementHandlerInterface
{
    public function createAgreement(ContractingPartyInterface $contractingParty, string $termReference): Agreement;

    public function getLastAgreement(ContractingPartyInterface $contractingParty, string $termReference): Agreement;

    public function getCurrentTerm(string $termReference): Term;

    public function getValidAgreement(ContractingPartyInterface $contractingParty, string $termReference): Agreement;
}
