<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\BaseClass\Item;
use App\Service\WolfService;
use Illuminate\Console\Command;

class SimpleCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:simpleCheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = 20;
        // Example of test items
        $items = [
            new Item('Apple AirPods', 10, 20),
            new Item('Samsung Galaxy S23', 5, 80),
            new Item('Apple iPad Air', 15, 20),
            new Item('Xiaomi Redmi Note 13', 5, 10),
            new Item('B-Phone', 5, 10),
        ];
        $wolfShop = new WolfService($items);

        // Loop through the days
        for ($day = 0; $day <= $days; $day++) {
            echo "** Day {$day} **\n";
            echo "Item Name                 | Sell In | Quality\n";

            foreach ($wolfShop->getWolfItems() as $item) {
                // Print current state of each item
                printf("%-25s | %7d | %7d\n", $item->name, $item->sellIn, $item->quality);
            }

            echo "-----------------------------------------------------------\n";

            // Update items for the next day
            $wolfShop->updateQuality();
        }
    }
}
