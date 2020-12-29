<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Groups({"show_element"})
     */
    protected int $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="This value can't to be blank!!")
     * @Assert\Length(
     *     min="1", minMessage="This value is so short min 3 char!!",
     *     max="50", maxMessage="This value can't be exceed 50 char!!"
     * )
     * @Groups({"show_element"})
     */
    private string $name;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     * @Groups({"show_element"})
     */
    private bool $isChecked = false;

    /**
     * @ORM\ManyToOne(targetEntity=CheckList::class, inversedBy="elements")
     */
    private ?CheckList $checkList;

    /**
     * @var string
     * @ORM\Column(type="string", length=7)
     * @Assert\NotBlank(message="This value can't to be blank!!")
     * @Assert\Length(max="7", maxMessage="This value {{ value }} can't be exceed 7 char!!")
     * @Assert\Regex(
     *     pattern     = "/^#[a-f0-9]+$/i",
     *     htmlPattern = "^#[a-fA-F0-9]+$"
     * )
     * @Groups({"show_element"})
     */
    private string $colorHexa = "#ffe333";

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getId(): int
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