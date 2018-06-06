<?php

namespace IDCI\Bundle\AgreementBundle\Repository;

use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;

interface AgreementRepositoryInterface
{
    /**
     * @param ContractingPartyInterface $contractingParty
     * @param string                    $termReference
     *
     * @return null|Agreement
     */
    public function findLastByTermReference(ContractingPartyInterface $contractingParty, $termReference);
}
