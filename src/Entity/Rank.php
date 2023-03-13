<?php

namespace App\Entity;

use App\Data\RankData;
use App\Repository\RankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: RankRepository::class)]
#[Vich\Uploadable()]
class Rank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $value = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: "ranks", fileNameProperty: "picture")]
    #[Assert\File(mimeTypes: [
        "image/png",
        "image/jpg",
        "image/jpeg",
        "image/svg+xml",
    ])]
    private ?File $pictureFile = null;

    #[ORM\OneToMany(mappedBy: 'rank', targetEntity: Employee::class)]
    private Collection $employees;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $abbreviation = [];

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->employees = new ArrayCollection();
    }

    public static function createFromData(RankData $data): Rank
    {
        return (new Rank())
            ->setName($data->getName())
            ->setValue([
                $data->getNonDefined(),
                $data->getFemale(),
                $data->getMale()
            ])
            ->setAbbreviation([
                $data->getAbrNonDefined(),
                $data->getAbrFemale(),
                $data->getAbrMale()
            ])
        ;
    }

    public function updateFromData(RankData $data): self
    {
        $this
            ->setName($data->getName())
            ->setValue([
                $data->getNonDefined(),
                $data->getFemale(),
                $data->getMale()
            ])
            ->setAbbreviation([
                $data->getAbrNonDefined(),
                $data->getAbrFemale(),
                $data->getAbrMale()
            ])
        ;

        return $this;
    }

    public function getRankData(): RankData
    {
        return (new RankData())
            ->setName($this->getName())
            ->setNonDefined($this->getValue()[0] ?? '')
            ->setFemale($this->getValue()[1] ?? '')
            ->setMale($this->getValue()[2] ?? '')
            ->setAbrNonDefined($this->getAbbreviation()[0] ?? '')
            ->setAbrFemale($this->getAbbreviation()[1] ?? '')
            ->setAbrMale($this->getAbbreviation()[2] ?? '')
        ;
    }

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

    public function getValue(): array
    {
        return $this->value;
    }

    public function setValue(array $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setPictureFile(File $file = null): self
    {
        $this->pictureFile = $file;

        if ($file) {
            $this->setUpdatedAt(new \DateTimeImmutable('now'));
        }
        return $this;
    }

    public function getPictureFile(): ?File
    {
        return $this->pictureFile;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Employee>
     */
    public function getEmployees(): Collection
    {
        return $this->employees;
    }

    public function addEmployee(Employee $employee): self
    {
        if (!$this->employees->contains($employee)) {
            $this->employees->add($employee);
            $employee->setRank($this);
        }

        return $this;
    }

    public function removeEmployee(Employee $employee): self
    {
        if ($this->employees->removeElement($employee)) {
            // set the owning side to null (unless already changed)
            if ($employee->getRank() === $this) {
                $employee->setRank(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getAbbreviation(): array
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(?array $abbreviation): self
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
