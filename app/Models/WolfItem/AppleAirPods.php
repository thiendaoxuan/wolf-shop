<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class AppleAirPods extends WolfItem
{
    public const NAME = 'Apple AirPods';

    public function update(): void
    {
        $this->sellIn--;
        $this->increaseQuality(1);
        if ($this->sellIn < 0) {
            $this->increaseQuality(1);
        }
    }
}
