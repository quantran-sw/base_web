<?php

namespace App\Entity\Traits;

use App\Constant;
use Doctrine\ORM\Mapping as ORM;

trait StatusEntityTrait
{
    #[ORM\Column(
        nullable: true,
        options: ["comment" => Constant::STATUS_ACTIVE . ": active; " . Constant::STATUS_INACTIVE . ": inactive"]
    )]
    private ?int $status = null;

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;

        return $this;
    }
}
