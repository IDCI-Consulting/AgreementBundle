<?php

namespace IDCI\Bundle\AgreementBundle\Repository;

use IDCI\Bundle\AgreementBundle\Model\Agreement;
use IDCI\Bundle\AgreementBundle\Model\ContractingPartyInterface;

interface AgreementRepositoryInterface
{
    public function findLastByTermReference(ContractingPartyInterface $contractingParty, string $termReference): ?Agreement;
}
