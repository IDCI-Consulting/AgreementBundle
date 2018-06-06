<?php

namespace IDCI\Bundle\AgreementBundle\Repository;

interface TermRepositoryInterface
{
    /**
     * @param string $termReference
     *
     * @return null|Term
     */
    public function findCurrent($termReference);
}
