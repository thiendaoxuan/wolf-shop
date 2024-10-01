<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class AppleAirPods extends WolfItem
{
    protected $table = 'wolf_items';
    public const NAME = 'Apple AirPods';

    public function updateByOneDay(): void
    {
        $this->sell_in--;
        $this->increaseQuality(1);
        if ($this->sell_in < 0) {
            $this->increaseQuality(1);
        }
    }
}
