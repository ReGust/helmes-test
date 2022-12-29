<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotEqualTo;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $sectors = [];

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $agree_to_terms;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSectors(): ?array
    {
        return $this->sectors;
    }

    public function setSectors(?array $sectors): self
    {
        $this->sectors = $sectors;

        return $this;
    }

    public function getAgreeToTerms(): ?string
    {
        return $this->agree_to_terms;
    }

    public function setAgreeToTerms(string $agree_to_terms): self
    {
        $this->agree_to_terms = $agree_to_terms;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('name', new NotBlank());
        $metadata->addPropertyConstraint('sectors', new NotBlank());
        $metadata->addPropertyConstraint('agree_to_terms', new NotBlank());
    }
}
