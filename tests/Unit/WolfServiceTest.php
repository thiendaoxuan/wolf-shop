<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\BaseClass\Item;
use App\Service\WolfService;
use PHPUnit\Framework\TestCase;

class WolfServiceTest extends TestCase
{
    public function testNormalItemQualityDecreases()
    {
        // Normal item example
        $items = [new Item('Normal Item', 10, 20)];
        $wolfService = new WolfService($items);

        $wolfService->updateQuality();
        $item = current($wolfService->getWolfItems())->toBaseItem();

        $this->assertEquals(19, $item->quality);
        $this->assertEquals(9, $item->sellIn);
    }

    public function testAppleAirPodIncreasesInQuality()
    {
        // Normal item example
        $items = [new Item('Apple AirPods', 10, 20)];
        $wolfService = new WolfService($items);

        $wolfService->updateQuality();
        $item = current($wolfService->getWolfItems())->toBaseItem();

        $this->assertEquals(21, $item->quality);
        $this->assertEquals(9, $item->sellIn);
    }

    public function testAppleIPadAirIncreaseInQuality()
    {
        // Increase in quality, but drops to 0 after the concert
        $items = [new Item('Apple iPad Air', 10, 20)];
        $wolfService = new WolfService($items);

        $wolfService->updateQuality();
        $item = current($wolfService->getWolfItems())->toBaseItem();

        $this->assertEquals(22, $item->quality);
        $this->assertEquals(9, $item->sellIn);
    }

    public function testAppleIPadAirQualityDropsToZeroAfterConcert()
    {
        // Quality drops to zero after the sell_in date
        $items = [new Item('Apple iPad Air', 0, 20)];
        $wolfService = new WolfService($items);

        $wolfService->updateQuality();
        $item = current($wolfService->getWolfItems())->toBaseItem();

        $this->assertEquals(0, $item->quality);
        $this->assertEquals(-1, $item->sellIn);
    }

    public function testS23NeverDecreasesInQuality()
    {
        // A legendary item, never decreases in quality
        $items = [new Item('Samsung Galaxy S23', 0, 80)];
        $wolfService = new WolfService($items);

        $wolfService->updateQuality();
        $item = current($wolfService->getWolfItems())->toBaseItem();

        $this->assertEquals(80, $item->quality);
        $this->assertEquals(0, $item->sellIn);
    }

    public function testQualityNeverGoesAbove50()
    {
        // Quality of any item cannot exceed 50
        $items = [new Item('Apple AirPods', 10, 50)];
        $wolfService = new WolfService($items);

        $wolfService->updateQuality();
        $item = current($wolfService->getWolfItems())->toBaseItem();

        $this->assertEquals(50, $item->quality);
    }

    public function testQualityNeverGoesBelowZero()
    {
        // Quality of any item cannot below 0
        $items = [new Item('Normal', 10, 0)];
        $wolfService = new WolfService($items);

        $wolfService->updateQuality();
        $item = current($wolfService->getWolfItems())->toBaseItem();

        $this->assertEquals(0, $item->quality);
    }
}
