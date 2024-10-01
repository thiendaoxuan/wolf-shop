<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class SamsungGalaxyS23 extends WolfItem
{
    protected $table = 'wolf_items';

    public const NAME = 'Samsung Galaxy S23';

    public function updateByOneDay(): void
    {
        // Does not change in quality or sellIn.
    }
}
