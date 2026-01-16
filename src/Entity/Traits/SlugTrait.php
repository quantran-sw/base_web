<?php

namespace App\Entity\Traits;

trait SlugTrait
{
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        // Nếu entity cần phải lưu lại các slug cũ cho mục đích redirect
        if (method_exists($this, 'addOldSlug') && $this->slug !== $slug) {
            $this->addOldSlug($this->slug);
        }

        $this->slug = $slug;

        return $this;
    }
}
