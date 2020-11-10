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
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     * @Groups({"get_user"})
     */
    private $title;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"get_user"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"get_user"})
     */
    private $isFinished = false;

    /**
     * @ORM\OneToMany(targetEntity=Element::class, mappedBy="checkList", orphanRemoval=true)
     * @Groups({"get_user"})
     */
    private $elements;

    /**
     * @var string
     * @ORM\Column(type="string", length=7)
     */
    private $colorHexa = "#ffe333";

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
}
