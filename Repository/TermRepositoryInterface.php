<?php

namespace IDCI\Bundle\AgreementBundle\Repository;

interface TermRepositoryInterface
{
    public function findCurrent($termReference);
}
