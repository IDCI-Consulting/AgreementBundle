<?php

namespace IDCI\Bundle\AgreementBundle\Handler;

use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;

interface AgreementHandlerInterface
{
    public function createAgreement(ContractingPartyInterface $contractingParty, $termReference);

    public function getLastAgreement(ContractingPartyInterface $contractingParty, $termReference);

    public function getCurrentTerm($termReference);

    public function getValidAgreement(ContractingPartyInterface $contractingParty, $termReference);
}
