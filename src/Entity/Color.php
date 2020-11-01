<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $hex;

    /**
     * @ORM\OneToMany(targetEntity=Element::class, mappedBy="color")
     */
    private $elements;

    /**
     * @ORM\OneToMany(targetEntity=CheckList::class, mappedBy="color")
     */
    private $checkLists;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $libel;

    public function __construct()
    {
        $this->elements = new ArrayCollection();
        $this->checkLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHex(): ?string
    {
        return $this->hex;
    }

    public function setHex(string $hex): self
    {
        $this->hex = $hex;

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
            $element->setColor($this);
        }

        return $this;
    }

    public function removeElement(Element $element): self
    {
        if ($this->elements->removeElement($element)) {
            // set the owning side to null (unless already changed)
            if ($element->getColor() === $this) {
                $element->setColor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CheckList[]
     */
    public function getCheckLists(): Collection
    {
        return $this->checkLists;
    }

    public function addCheckList(CheckList $checkList): self
    {
        if (!$this->checkLists->contains($checkList)) {
            $this->checkLists[] = $checkList;
            $checkList->setColor($this);
        }

        return $this;
    }

    public function removeCheckList(CheckList $checkList): self
    {
        if ($this->checkLists->removeElement($checkList)) {
            // set the owning side to null (unless already changed)
            if ($checkList->getColor() === $this) {
                $checkList->setColor(null);
            }
        }

        return $this;
    }

    public function getLibel(): ?string
    {
        return $this->libel;
    }

    public function setLibel(string $libel): self
    {
        $this->libel = $libel;

        return $this;
    }
}
