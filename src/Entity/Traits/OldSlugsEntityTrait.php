<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait OldSlugsEntityTrait
{
    #[ORM\Column(nullable: true)]
    private ?array $oldSlugs = null;

    public function getOldSlugs(): ?array
    {
        return $this->oldSlugs;
    }

    public function setOldSlugs(?array $oldSlugs): static
    {
        $this->oldSlugs = $oldSlugs;

        return $this;
    }

    public function addOldSlug(string $oldSlug): static
    {
        if (!in_array($oldSlug, $this->oldSlugs)) {
            $this->oldSlugs[] = $oldSlug;
        }

        return $this;
    }
}
