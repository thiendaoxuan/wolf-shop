<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

class SamsungGalaxyS23 extends WolfItem
{
    public const NAME = 'Samsung Galaxy S23';

    protected $table = 'wolf_items';

    public function updateByOneDay(): void
    {
        // Does not change in quality or sellIn.
    }
}
