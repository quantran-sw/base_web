<?php

namespace App\Entity;

use App\Entity\Traits\IdEntityTrait;
use App\Entity\Traits\NameEntityTrait;
use App\Entity\Traits\OldSlugsEntityTrait;
use App\Entity\Traits\SlugEntityTrait;
use App\Entity\Traits\StatusEntityTrait;
use App\Entity\Traits\TimestampEntityTrait;
use App\Repository\ProgramRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Program
{
    use IdEntityTrait;
    use NameEntityTrait;
    use SlugEntityTrait;
    use OldSlugsEntityTrait;
    use StatusEntityTrait;
    use TimestampEntityTrait;

    #[ORM\ManyToOne(inversedBy: 'programs')]
    private ?School $school = null;

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): static
    {
        $this->school = $school;

        return $this;
    }
}
