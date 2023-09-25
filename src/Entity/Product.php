<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\CurrencyEnum;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, name: 'title')]
    private string $title;

    #[ORM\Column(type: 'float', name: 'price')]
    private float $price;

    #[ORM\Column(name: 'currency', type: 'string')]
    /** @type CurrencyEnum $currrency */
    private $currency;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    public function setCurrency(CurrencyEnum $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

}
