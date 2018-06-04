<?php

namespace IDCI\Bundle\AgreementBundle\Repository;

use IDCI\Bundle\AgreementBundle\Model\Term;

interface TermRepositoryInterface
{
    public function findCurrent(string $termReference): ?Term;
}
