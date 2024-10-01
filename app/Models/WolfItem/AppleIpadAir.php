<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class AppleIpadAir extends WolfItem
{
    protected $table = 'wolf_items';

    public const NAME = 'Apple iPad Air';

    public function updateByOneDay(): void
    {
        $this->sell_in--;
        if ($this->sell_in < 0) {
            $this->quality = self::MIN_QUALITY;
        } elseif ($this->sell_in <= 5) {
            $this->increaseQuality(3);
        } elseif ($this->sell_in <= 10) {
            $this->increaseQuality(2);
        } else {
            $this->increaseQuality(1);
        }
    }
}
