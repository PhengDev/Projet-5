<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @UniqueEntity("title")
 */
class Property
{
    const RARITY = [
        0=> 'Uncommon',
        1=> 'Commom',
        2=> 'Rare',
        3=> 'Super Rare',
        4=> 'Spécial Rare',
        5=> 'Starter Rare',
        6=> 'Secret Rare',
        7=> 'Destruction Rare',
        8=> 'Expansion Rare',
        9=> 'Promotion'
    ];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

     /**
     * @Assert\Range(min=5, max=255)
     * @ORM\Column(type="string", length=255)
     */
    private $type;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $series;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $color;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $origin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $era;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $personage;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $rarity;

    /**
     * @ORM\Column(type="integer")
     */
    private $power;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $costEnergy;

    /**
     * @ORM\Column(type="integer")
     */
    private $costCombo;

    /**
     * @ORM\Column(type="integer")
     */
    private $powerCombo;

     /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $sold = false;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    public function __construct()
    {
        $this -> created_at = new \DateTime();
    }
   

    public function getId(): ?int
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

   public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function getFormatedPower(): string
    {
        return number_format($this->power, 0, '', ' ');
    }

    public function getFormatedPowerCombo(): string
    {
        return number_format($this->powerCombo, 0, '', ' ');
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getCostEnergy(): ?int
    {
        return $this->costEnergy;
    }

    public function setCostEnergy(int $costEnergy): self
    {
        $this->costEnergy = $costEnergy;

        return $this;
    }

    public function getCostCombo(): ?int
    {
        return $this->costCombo;
    }

    public function setCostCombo(int $costCombo): self
    {
        $this->costCombo = $costCombo;

        return $this;
    }

    public function getPowerCombo(): ?int
    {
        return $this->powerCombo;
    }

    public function setPowerCombo(int $powerCombo): self
    {
        $this->powerCombo = $powerCombo;

        return $this;
    }

    public function getPersonage(): ?string
    {
        return $this->personage;
    }

    public function setPersonage(string $personage): self
    {
        $this->personage = $personage;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(string $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getEra(): ?string
    {
        return $this->era;
    }

    public function setEra(string $era): self
    {
        $this->era = $era;

        return $this;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(string $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getRarity(): ?string
    {
        return $this->rarity;
    }

    public function setRarity(string $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getRarityType(): string
    {
        return self::RARITY[$this->rarity];
    }

 
}
