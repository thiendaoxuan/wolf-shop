<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\WolfItem\AppleAirPods;
use App\Models\WolfItem\AppleIpadAir;
use App\Models\WolfItem\SamsungGalaxyS23;
use App\Models\WolfItem\WolfItem;
use App\Models\WolfItem\XiaomiRedmiNote13;
use Illuminate\Support\Collection;

/**
 * This service is for interacting with DB
 */
class WolfServiceV2
{
    public const CHUNK_SIZE = 5;

    public function updateAllItem(): void
    {
        $update_func = function ($items) {
            foreach ($items as $item) {
                $item->updateByOneDay();
                $item->save();
            }
        };

        // todo : can improve by using multiple machine at once, and can apply transaction
        AppleAirPods::query()->where('name', AppleAirPods::NAME)->orderBy('id')->chunk(self::CHUNK_SIZE, $update_func);
        AppleIpadAir::query()->where('name', AppleIpadAir::NAME)->orderBy('id')->chunk(self::CHUNK_SIZE, $update_func);
        XiaomiRedmiNote13::query()->where('name', XiaomiRedmiNote13::NAME)->orderBy('id')->chunk(self::CHUNK_SIZE, $update_func);
        $specialItems = [AppleAirPods::NAME, AppleIpadAir::NAME, XiaomiRedmiNote13::NAME, SamsungGalaxyS23::NAME];
        WolfItem::query()->whereNotIn('name', $specialItems)->orderBy('id')->chunk(self::CHUNK_SIZE, $update_func);
    }

    public function list($name, $limit = 10, $offset = 0): Collection
    {
        return match ($name) {
            AppleIpadAir::NAME => AppleIpadAir::query()->orderBy('id')->limit($limit)->offset($offset)->get(),
            AppleAirPods::NAME => AppleAirPods::query()->orderBy('id')->limit($limit)->offset($offset)->get(),
            SamsungGalaxyS23::NAME => SamsungGalaxyS23::query()->orderBy('id')->limit($limit)->offset($offset)->get(),
            XiaomiRedmiNote13::NAME => XiaomiRedmiNote13::query()->orderBy('id')->limit($limit)->offset($offset)->get(),
            default => WolfItem::query()->orderBy('id')->limit($limit)->offset($offset)->get()
        };
    }
}
