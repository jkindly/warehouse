<?php

namespace App\Entity;

use App\Repository\AttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttributeRepository::class)]
class Attribute
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'attribute', targetEntity: AttributeValue::class)]
    private Collection $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, AttributeValue>
     */
    public function getValues(): Collection
    {
        return $this->values;
    }

    public function addValues(AttributeValue $values): static
    {
        if (!$this->values->contains($values)) {
            $this->values->add($values);
            $values->setAttribute($this);
        }

        return $this;
    }

    public function removeValues(AttributeValue $values): static
    {
        if ($this->values->removeElement($values)) {
            // set the owning side to null (unless already changed)
            if ($values->getAttribute() === $this) {
                $values->setAttribute(null);
            }
        }

        return $this;
    }
}
