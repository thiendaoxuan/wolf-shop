<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class XiaomiRedmiNote13 extends WolfItem
{
    public const NAME = 'Xiaomi Redmi Note 13';

    public function update(): void
    {
        $this->sellIn--;

        // Decrease quality by 2
        $this->decreaseQuality(2);

        if ($this->sellIn < 0) {
            // If sell_in is below 0, decrease quality again by 2
            $this->decreaseQuality(2);
        }
    }
}
