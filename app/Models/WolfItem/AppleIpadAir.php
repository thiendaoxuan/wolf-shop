<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class AppleIpadAir extends WolfItem
{
    public const NAME = 'Apple iPad Air';

    public function update(): void
    {
        $this->sellIn--;
        if ($this->sellIn < 0) {
            $this->quality = self::MIN_QUALITY;
        } elseif ($this->sellIn <= 5) {
            $this->increaseQuality(3);
        } elseif ($this->sellIn <= 10) {
            $this->increaseQuality(2);
        } else {
            $this->increaseQuality(1);
        }
    }
}
