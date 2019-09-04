<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @UniqueEntity("title")
 * @Vich\Uploadable
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

    const TYPE = [
        0=> 'LEADER',
        1=> 'COMBAT',
        2=> 'EXTRA',
        3=> 'BONUS'
    ];

    const COLOR = [
        0=> 'Rouge',
        1=> 'Vert',
        2=> 'Blue',
        3=> 'Jaune',
        4=> 'Noir',
        5=> 'Bleu / Jaune',
        6=> 'Rouge / Vert'
    ];

    const ORIGIN = [
        0=> 'Alien',
        1=> 'Androide',
        2=> 'Armée de Chilled',
        3=> 'Armée de Freezer',
        4=> 'Armée de Slug',
        5=> 'Agent de la Destruction',
        6=> 'Brigade de Bojack',
        7=> 'Clan de Freezer',
        8=> 'Commando Ginyu',
        9=> 'Cooler Toku Sentai',
        10=> 'Démon',
        11=> 'Démon chimérique',
        12=> 'Equipe de Barock'
    ];

    const PERSONAGE = [
        0=> 'Apple',
        1=> 'Anguila',
        2=> 'Anilaza',
        3=> 'Assistant de Kaoi Shin',
        4=> 'Ba (Br)',
        5=> 'Baby',
        6=> 'Bacterian',
        7=> 'Banan',
        8=> 'Bardock',
        9=> 'Basil',
        10=> 'Beerus',
        11=> 'Beets (Br)',
        12=> 'Bergamo',
        13=> 'Beeryblue (Br)',
        14=> 'Bido',
        15=> 'Bizu',
        16=> 'Bojack',
        17=> 'Boo',
        18=> 'Botamo',
        19=> 'Boule à 1 étoile',
        20=> 'Boule à 2 étoiles',
        21=> 'Boule à 3 étoiles',
        22=> 'Boule à 4 étoiles',
        23=> 'Boule à 5 étoiles',
        24=> 'Broly',
        25=> 'Son Goku',
        26=> 'Son Goten'
    ];

    const COSTENERGY = [
        0=> '0',
        1=> '1',
        2=> '2',
        3=> '3',
        4=> '4',
        5=> '5',
        6=> '6',
        7=> '7',
        8=> '8',
        9=> '9',
        10=> '10'
    ];

    const ERA = [
        0=> 'Baby',
        1=> 'Bardock',
        2=> 'Bojack',
        3=> 'Boo',
        4=> 'Broly',
        5=> 'Baby',
        6=> 'Champa',
        7=> 'Chilled',
        8=> 'Cooler',
        9=> 'DBS (Broly)',
        10=> 'Dragon Ball Minus',
        11=> 'Freezer',
        12=> 'Hirudegarn',
        13=> 'Inconnu',
        14=> 'Jaco, Le Patrouilleur Galatique',
        15=> 'Janemba',
        16=> 'L\'Androïde Cell',
        17=> 'L\'Armée du ruban rouge',
        18=> 'L\'Aventure mystique',
        19=> 'La Légende de Shenron',
        20=> 'La Réssurection de (F)',
        21=> 'La Survie de L\'Univers',
        22=> 'Le Combat des Dieux',
        23=> 'Le Royaume des Démons',
    ];

    const SERIES = [
        0=> 'BT1 - Booster 1 ~ Galatique Battle',
        1=> 'BT2 - Booster 2 ~ Union Force',
        2=> 'BT3 - Booster 3 ~ Les Mondes Croisés',
        3=> 'BT4 - Booster 4 ~ Colossal Warfare',
        4=> 'BT5 - Booster 5 ~ Miraculus Revival',
        5=> 'BT6 - Booster 6 ~ Destroyer King',
        6=> 'DBS-TB01 - Thème ~ The Tournament Of Power',
        7=> 'DBS-TB02 - Thème ~ World Martial Art Tournament',
        8=> 'SD1 - Started 1 ~ The Awakening',
        9=> 'SD2 - Started 2 ~ The Extreme Evolution',
        10=> 'SD3 - Started 3 ~ The Dark Invasion',
        11=> 'SD4 - Started 4 ~ The Guardian Of Namekians',
        12=> 'SD5 - Started 5 ~ The Crimson Sayan',
        13=> 'SD6 - Started 6 ~ Resurrected Fusion',
        14=> 'SD7 - Started 7 ~ Shenron\'s Advent',
        15=> 'SD8 - Started 8 ~ Resing Broly'
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

      /**
     * 
     * @Vich\UploadableField(mapping="property_image", fileNameProperty="fileName")
     * @Assert\Image(mimeTypes="image/jpeg")
     * 
     * @var File|null
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string|null
     */
    private $fileName;

     /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

     /**
     * @ORM\Column(type="integer")
     */
    private $type;

     /**
     * @ORM\Column(type="integer")
     */
    private $series;

     /**
     * @ORM\Column(type="integer")
     */
    private $color;

     /**
     *@ORM\Column(type="integer")
     */
    private $origin;

    /**
     *@ORM\Column(type="integer")
     */
    private $era;

     /**
     * @ORM\Column(type="integer")
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

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * 
     *  * @var \DateTime|null
     */
    private $updated_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getColor(): ?int
    {
        return $this->color;
    }

    public function setColor(int $color): self
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

    public function getPersonage(): ?int
    {
        return $this->personage;
    }

    public function setPersonage(int $personage): self
    {
        $this->personage = $personage;

        return $this;
    }

    public function getOrigin(): ?int
    {
        return $this->origin;
    }

    public function setOrigin(int $origin): self
    {
        $this->origin = $origin;

        return $this;
    }

    public function getEra(): ?int
    {
        return $this->era;
    }

    public function setEra(int $era): self
    {
        $this->era = $era;

        return $this;
    }

    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(int $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getRarity(): ?int
    {
        return $this->rarity;
    }

    public function setRarity(int $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getRarityType(): string
    {
        return self::RARITY[$this->rarity];
    }

    public function getTypeType(): string
    {
        return self::TYPE[$this->type];
    }

    public function getOriginType(): string
    {
        return self::ORIGIN[$this->origin];
    }

    public function getColorType(): string
    {
        return self::COLOR[$this->color];
    }

    public function getCostEnergyType(): string
    {
        return self::COSTENERGY[$this->costEnergy];
    }

    public function getEraType(): string
    {
        return self::ERA[$this->era];
    }

    public function getSeriesType(): string
    {
        return self::SERIES[$this->series];
    }

    public function getPersonageType(): string
    {
        return self::PERSONAGE[$this->personage];
    }

    /**
     * Get the value of imageFile
     *
     * @return  File|null
     */ 
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Set the value of imageFile
     *
     * @param  File|null  $imageFile
     *
     * @return  self
     */ 
    public function setImageFile(?File $imageFile = null): Property
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at = new \DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of fileName
     *
     * @return  string|null
     */ 
    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @param  string|null  $fileName
     *
     * @return  self
     */ 
    public function setFileName(?string $fileName): Property
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
