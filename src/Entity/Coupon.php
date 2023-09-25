<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\CouponTypeEnum;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Coupon
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, name: 'type')]
    private CouponTypeEnum $type;

    #[ORM\Column(length: 255, name: 'code')]
    private string $code;

    #[ORM\Column(type: 'float', name: 'amount')]
    private float $amount;

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): CouponTypeEnum
    {
        return $this->type;
    }

    public function setType(CouponTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode($code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDiscountedPrice(float $price): float
    {
        if (self::getType() === CouponTypeEnum::AMOUNT_PERCENT) {
            return $price * ((100-$this->amount)/100);
        } else {
            return $price - $this->amount;
        }
    }
}
