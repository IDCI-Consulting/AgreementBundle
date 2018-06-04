<?php

namespace IDCI\Bundle\AgreementBundle\Model;

use Ramsey\Uuid\Uuid;

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

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference($reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion($version): self
    {
        $this->version = $version;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUri(): ?string
    {
        return $this->uri;
    }

    public function setUri($uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    public function getApplicableAt(): ?\DateTime
    {
        return $this->applicableAt;
    }

    public function setApplicableAt($applicableAt): self
    {
        $this->applicableAt = $applicableAt;

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
}
