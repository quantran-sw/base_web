<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait NameEntityTrait
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
