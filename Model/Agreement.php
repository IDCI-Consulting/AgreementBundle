<?php

namespace IDCI\Bundle\AgreementBundle\Model;

class Agreement
{
    private $id;
    private $contractingPartyUuid;
    private $createdAt;
    private $term;

    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime('now'));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getContractingPartyUuid()
    {
        return $this->contractingPartyUuid;
    }

    public function setContractingPartyUuid($contractingPartyUuid)
    {
        $this->contractingPartyUuid = $contractingPartyUuid;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTerm()
    {
        return $this->term;
    }

    public function setTerm(Term $term)
    {
        $this->term = $term;

        return $this;
    }
}
