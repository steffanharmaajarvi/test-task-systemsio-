<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\CountryEnum;
use App\Enum\CouponTypeEnum;

class Tax
{

    private const TAXES_BY_COUNTRIES = [
        CountryEnum::DE->value => 19,
        CountryEnum::IT->value => 22,
        CountryEnum::FR->value => 20,
        CountryEnum::GR->value => 24,
    ];

    public function __construct(
        private string $taxNumber
    )
    {
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function getTaxPercent(): int
    {
        $counry = $this->getCountryByTaxNumber();

        return self::TAXES_BY_COUNTRIES[$counry->value];
    }

    private function getCountryByTaxNumber(): CountryEnum
    {
        try {
            $countryCode = substr($this->taxNumber, 0, 2);

            return CountryEnum::fromCode($countryCode);
        } catch (\Throwable) {
            throw new \Exception('Tax number not supported');
        }
    }
}