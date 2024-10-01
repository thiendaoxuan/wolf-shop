<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

use App\Models\BaseClass\Item;

class WolfItem extends Item
{
    protected const MAX_QUALITY = 50;

    protected const MIN_QUALITY = 0;

    public function update(): void
    {
        $this->sellIn--;
        if ($this->sellIn < 0) {
            $this->decreaseQuality(2);
        } else {
            $this->decreaseQuality(1);
        }
    }

    protected function decreaseQuality($amount): void
    {
        $this->quality = max(self::MIN_QUALITY, $this->quality - $amount);
    }

    protected function increaseQuality($amount): void
    {
        $this->quality = min(self::MAX_QUALITY, $this->quality + $amount);
    }
}
