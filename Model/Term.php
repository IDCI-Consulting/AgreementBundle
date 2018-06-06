<?php

namespace IDCI\Bundle\AgreementBundle\Model;

class Term
{
    private $id;
    private $reference;
    private $version;
    private $description;
    private $uri;
    private $applicableAt;
    private $createdAt;

    public function onPrePersist()
    {
        $this->setCreatedAt(new \DateTime('now'));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function getApplicableAt()
    {
        return $this->applicableAt;
    }

    public function setApplicableAt($applicableAt)
    {
        $this->applicableAt = $applicableAt;

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
}
