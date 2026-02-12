<?php

namespace App\DTO\Program;

use App\DTO\BaseInputDTO;
use App\Entity\Program;
use App\Entity\School;
use App\Util\Attribute\Transformer\EntityTransformer;
use App\Util\ObjectMapper\SchoolTransformer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: Program::class)]
class ProgramCreateOneInput extends BaseInputDTO
{
    #[Assert\NotBlank()]
    #[Assert\Length(
        max: 255,
    )]
    public ?string $name = null;

    public ?int $status = null;

    #[EntityTransformer(School::class)]
    public ?int $schoolId = null;
}