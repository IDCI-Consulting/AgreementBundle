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

    /**
     * @return Ramsey\Uuid\Uuid
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContractingPartyUuid()
    {
        return $this->contractingPartyUuid;
    }

    /**
     * @param string $contractingPartyUuid
     *
     * @return self
     */
    public function setContractingPartyUuid($contractingPartyUuid)
    {
        $this->contractingPartyUuid = $contractingPartyUuid;

        return $this;
    }

    /*
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Term
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param Term $term
     *
     * @return self
     */
    public function setTerm(Term $term)
    {
        $this->term = $term;

        return $this;
    }
}
