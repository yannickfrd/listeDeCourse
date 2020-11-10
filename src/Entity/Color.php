<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Color
 * @package App\Entity
 * @ORM\Entity(repositoryClass=ColorRepository::class)
 */
class Color {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=7)
     * @Assert\NotBlank(message="This value can't to be blank!!")
     * @Assert\Length(max="7", maxMessage="This value {{ value }} can't be exceed 7 char!!")
     * @Assert\Regex(
     *     pattern     = "/^#[a-f0-9]+$/i",
     *     htmlPattern = "^#[a-fA-F0-9]+$"
     * )
     */
    private string $ColorHexa;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank(message="This value can't to be blank!!")
     * @Assert\Length(
     *     min="3", minMessage="This value is so short min 3 char!!",
     *     max="20", maxMessage="This value can't be exceed 50 char!!"
     * )
     */
    private string $libel;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getColorHexa()
    {
        return $this->ColorHexa;
    }

    /**
     * @param mixed $ColorHexa
     * @return Color
     */
    public function setColorHexa($ColorHexa)
    {
        $this->ColorHexa = $ColorHexa;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLibel()
    {
        return $this->libel;
    }

    /**
     * @param mixed $libel
     * @return Color
     */
    public function setLibel($libel)
    {
        $this->libel = $libel;
        return $this;
    }
}
