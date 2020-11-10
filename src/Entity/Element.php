<?php

namespace App\Entity;

use App\Repository\ElementRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Element
 * @package App\Entity
 * @ORM\Entity(repositoryClass=ElementRepository::class)
 */
class Element {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isChecked = false;

    /**
     * @ORM\ManyToOne(targetEntity=CheckList::class, inversedBy="elements")
     */
    private $checkList;

    /**
     * @var string
     * @ORM\Column(type="string", length=7)
     */
    private $colorHexa = "#ffe333";

    /**
     * @return mixed
     */
    public function getId()
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

    public function getIsChecked(): ?bool
    {
        return $this->isChecked;
    }

    public function setIsChecked(bool $isChecked): self
    {
        $this->isChecked = $isChecked;

        return $this;
    }

    public function getCheckList(): ?CheckList
    {
        return $this->checkList;
    }

    public function setCheckList(?CheckList $checkList): self
    {
        $this->checkList = $checkList;

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
