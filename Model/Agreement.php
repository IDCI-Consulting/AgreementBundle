<?php

namespace IDCI\Bundle\AgreementBundle\Model;

use Ramsey\Uuid\Uuid;

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

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getContractingPartyUuid(): string
    {
        return $this->contractingPartyUuid;
    }

    public function setContractingPartyUuid(string $contractingPartyUuid): self
    {
        $this->contractingPartyUuid = $contractingPartyUuid;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTerm(): ?Term
    {
        return $this->term;
    }

    public function setTerm(Term $term): self
    {
        $this->term = $term;

        return $this;
    }
}
