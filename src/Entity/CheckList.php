<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Repository\CheckListRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class CheckList
 * @package App\Entity
 * @ORM\Entity(repositoryClass=CheckListRepository::class)
 */
class CheckList {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(
     *     message="This value can't to be blank!!"
     * )
     * @Assert\Length(
     *     min="3", minMessage="This value is so short min 3 char!!",
     *     max="50", maxMessage="This value can't be exceed 50 char!!"
     *  )
     * @Groups({"get_user"})
     */
    private string $title;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"get_user"})
     */
    private DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get_user"})
     */
    private bool $isFinished = false;

    /**
     * @ORM\OneToMany(targetEntity=Element::class, mappedBy="checkList", orphanRemoval=true)
     * @Groups({"get_user"})
     */
    private $elements;

    /**
     * @var string
     * @ORM\Column(type="string", length=7)
     * @Groups({"get_user"})
     * @Assert\NotBlank(message="This value can't to be blank!!")
     * @Assert\Length(max="7", maxMessage="This value {{ value }} can't be exceed 7 char!!")
     * @Assert\Regex(
     *     pattern     = "/^#[a-f0-9]+$/i",
     *     htmlPattern = "^#[a-fA-F0-9]+$"
     * )
     */
    private $colorHexa = "#ffe333";

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="checklists")
     */
    private $user;

    public function __construct() {
        $this->createdAt = new DateTimeImmutable();
        $this->elements = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    /**
     * @return Collection|Element[]
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function addElement(Element $element): self
    {
        if (!$this->elements->contains($element)) {
            $this->elements[] = $element;
            $element->setCheckList($this);
        }

        return $this;
    }

    public function removeElement(Element $element): self
    {
        if ($this->elements->removeElement($element)) {
            // set the owning side to null (unless already changed)
            if ($element->getCheckList() === $this) {
                $element->setCheckList(null);
            }
        }

        return $this;
    }

    public function getColorHexa(): ?string
    {
        return $this->colorHexa;
    }

    public function setColorHexa(string $colorHexa): self
    {
        $this->colorHexa = $colorHexa;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
