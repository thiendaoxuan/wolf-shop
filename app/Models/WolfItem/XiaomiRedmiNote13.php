<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class XiaomiRedmiNote13 extends WolfItem
{
    public const NAME = 'Xiaomi Redmi Note 13';

    protected $table = 'wolf_items';

    public function updateByOneDay(): void
    {
        $this->sell_in--;

        // Decrease quality by 2
        $this->decreaseQuality(2);

        if ($this->sell_in < 0) {
            // If sell_in is below 0, decrease quality again by 2
            $this->decreaseQuality(2);
        }
    }
}
