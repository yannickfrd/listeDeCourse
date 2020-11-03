<?php

namespace App\Entity;

use App\Repository\ColorRepository;
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
    private $id;

    /**
     * @ORM\Column(type="string", length=7)
     */
    private $ColorHexa;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $libel;

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
