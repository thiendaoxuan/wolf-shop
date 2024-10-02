<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\WolfItem\WolfItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Throwable;

class ImportFromUrl extends Command
{
    public const URL = 'https://api.restful-api.dev/objects';

    public const DEFAULT_INITIAL_SELL_IN = 10;

    public const DEFAULT_INITIAL_QUALITY = 10;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-url';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from URL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $itemData = null;
        try {
            $rawDataFromUrl = Http::get(self::URL)->body();
            $itemData = json_decode($rawDataFromUrl, true);
        } catch (Throwable $e) {
            print_r('Cannot fetch data from URL. Error: ' . $e);
        }

        $itemData = collect($itemData);
        // Remove any duplicate name from URL response
        $itemData = $itemData->unique('name');

        $existingItems = WolfItem::query()->whereIn('name', $itemData->pluck('name'))->get();
        $existingItems = $existingItems->keyBy('name');

        foreach ($itemData as $item) {
            $name = $item['name'];

            /** @var WolfItem $existingItem */
            $existingItem = $existingItems[$name] ?? null;
            if (! empty($existingItem)) {
                echo $name . ' existed. Increase Quality by 1' . "\n";
                $existingItem->quality = $existingItem->quality + 1;
                $existingItem->save();
            } else {
                echo $name . ' not existed. Create with default initial value' . "\n";
                $wolf_item = new WolfItem(
                    [
                        'name' => $name,
                        'sell_in' => self::DEFAULT_INITIAL_SELL_IN,
                        'quality' => self::DEFAULT_INITIAL_QUALITY,
                    ]
                );
                $wolf_item->save();
            }
        }
    }
}
