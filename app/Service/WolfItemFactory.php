<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\BaseClass\Item;
use App\Models\WolfItem\AppleAirPods;
use App\Models\WolfItem\AppleIpadAir;
use App\Models\WolfItem\SamsungGalaxyS23;
use App\Models\WolfItem\WolfItem;
use App\Models\WolfItem\XiaomiRedmiNote13;

class WolfItemFactory
{
    /**
     * We actually don't use the provided Item class, we transform them into our custom class instead
     */
    public static function create(Item $item): WolfItem|AppleIpadAir|AppleAirPods|SamsungGalaxyS23
    {
        $name = $item->name;
        $sellIn = $item->sellIn;
        $initialQuality = $item->quality;

        return match ($name) {
            AppleIpadAir::NAME => new AppleIpadAir($name, $sellIn, $initialQuality),
            AppleAirPods::NAME => new AppleAirPods($name, $sellIn, $initialQuality),
            SamsungGalaxyS23::NAME => new SamsungGalaxyS23($name, $sellIn, $initialQuality),
            XiaomiRedmiNote13::NAME => new XiaomiRedmiNote13($name, $sellIn, $initialQuality),
            default => new WolfItem($name, $sellIn, $initialQuality)
        };
    }
}
