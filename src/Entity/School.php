<?php

namespace App\Entity;

use App\Entity\Traits\IdEntityTrait;
use App\Entity\Traits\NameEntityTrait;
use App\Entity\Traits\OldSlugsEntityTrait;
use App\Entity\Traits\SlugEntityTrait;
use App\Entity\Traits\StatusEntityTrait;
use App\Entity\Traits\TimestampEntityTrait;
use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SchoolRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class School
{
    use IdEntityTrait;
    use NameEntityTrait;
    use SlugEntityTrait;
    use OldSlugsEntityTrait;
    use StatusEntityTrait;
    use TimestampEntityTrait;

    /**
     * @var Collection<int, Program>
     */
    #[ORM\OneToMany(targetEntity: Program::class, mappedBy: 'school')]
    private Collection $programs;

    public function __construct()
    {
        $this->programs = new ArrayCollection();
    }

    /**
     * @return Collection<int, Program>
     */
    public function getPrograms(): Collection
    {
        return $this->programs;
    }

    public function addProgram(Program $program): static
    {
        if (!$this->programs->contains($program)) {
            $this->programs->add($program);
            $program->setSchool($this);
        }

        return $this;
    }

    public function removeProgram(Program $program): static
    {
        if ($this->programs->removeElement($program)) {
            // set the owning side to null (unless already changed)
            if ($program->getSchool() === $this) {
                $program->setSchool(null);
            }
        }

        return $this;
    }
}
