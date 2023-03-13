<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[Vich\Uploadable()]
class Employee
{
    const GENDER_NAMES = [
        "Non-défini",
        "Femme",
        "Homme"
    ];

    const TYPE_NAMES = [
        true => 'Police',
        false => 'Civil'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(nullable: true)]
    private ?int $badge_number = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $birthdate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column]
    private ?bool $isPolice = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: "employees", fileNameProperty: "picture")]
    #[Assert\File(mimeTypes: [
        "image/png",
        "image/jpg",
        "image/jpeg",
    ])]
    private ?File $pictureFile = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Role $role = null;

    #[ORM\ManyToOne(inversedBy: 'employees')]
    private ?Rank $rank = null;

    #[ORM\Column]
    private ?int $gender = null;

    #[ORM\OneToMany(mappedBy: 'employee', targetEntity: Card::class)]
    private Collection $cards;

    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->setIsPolice(false);
        $this->setGender(0);
        $this->setPhoneNumber("+41218111919");
    }

    public function __toString(): string
    {
        return $this->getFullname();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return strtoupper($this->lastname);
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFullname(): string
    {
        return $this->getRankAbbreviation() . " " . $this->getLastname() . " " . $this->getFirstname();
    }

    public function getBadgeNumber(): ?int
    {
        return $this->badge_number;
    }

    public function setBadgeNumber(?int $badge_number): self
    {
        $this->badge_number = $badge_number;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeImmutable $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isIsPolice(): ?bool
    {
        return $this->isPolice;
    }

    public function setIsPolice(bool $isPolice): self
    {
        $this->isPolice = $isPolice;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

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

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function getRoleValue(): string
    {
        return $this->getRole()->getValue()[$this->getGender()];
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRank(): ?Rank
    {
        return $this->rank;
    }

    public function getRankValue(): string
    {
        return $this->getRank()->getValue()[$this->getGender()];
    }

    public function getRankAbbreviation(): string
    {
        return $this->getRank()->getAbbreviation()[$this->getGender()];
    }

    public function setRank(?Rank $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getGender(): ?int
    {
        return $this->gender;
    }

    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection<int, Card>
     */
    public function getCards(): Collection
    {
        return $this->cards;
    }

    public function addCard(Card $card): self
    {
        if (!$this->cards->contains($card)) {
            $this->cards->add($card);
            $card->setEmployee($this);
        }

        return $this;
    }

    public function removeCard(Card $card): self
    {
        if ($this->cards->removeElement($card)) {
            // set the owning side to null (unless already changed)
            if ($card->getEmployee() === $this) {
                $card->setEmployee(null);
            }
        }

        return $this;
    }

    public function getGenderName(): string
    {
        return self::GENDER_NAMES[$this->getGender()];
    }

    public function getRoleType(): string
    {
        return self::TYPE_NAMES[$this->isIsPolice()];
    }

}
