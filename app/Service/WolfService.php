<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\WolfItem\WolfItem;

final class WolfService
{
    private array $items;

    public function __construct(
        array $items
    ) {
        foreach ($items as $item) {
            $this->items[$item->name] = WolfItemFactory::create($item);
        }
    }

    public function updateQuality(): void
    {
        /** @var WolfItem $item */
        foreach ($this->items as $item) {
            $item->update();
        }
    }

    public function getWolfItems(): array
    {
        return $this->items;
    }
}
