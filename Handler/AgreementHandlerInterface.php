<?php

namespace IDCI\Bundle\AgreementBundle\Handler;

use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;

interface AgreementHandlerInterface
{
    /**
     * @param ContractingPartyInterface $contractingParty
     * @param string                    $termReference
     *
     * @return Agreement
     */
    public function createAgreement(ContractingPartyInterface $contractingParty, $termReference);

    /**
     * @param ContractingPartyInterface $contractingParty
     * @param string                    $termReference
     *
     * @return Agreement
     */
    public function getLastAgreement(ContractingPartyInterface $contractingParty, $termReference);

    /**
     * @param string $termReference
     *
     * @return Term
     */
    public function getCurrentTerm($termReference);

    /**
     * @param ContractingPartyInterface $contractingParty
     * @param string                    $termReference
     *
     * @return Agreement
     */
    public function getValidAgreement(ContractingPartyInterface $contractingParty, $termReference);
}
