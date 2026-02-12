<?php

namespace App\DTO\School;

use App\DTO\BaseInputDTO;
use App\Entity\School;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: School::class)]
class SchoolInput extends BaseInputDTO
{
    #[Assert\NotBlank()]
    #[Assert\Length(
        max: 255,
    )]
    public ?string $name = null;

    #[Assert\Choice(
        options: [0, 1]
    )]
    public ?int $status = null;
}