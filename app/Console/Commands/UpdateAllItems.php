<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\WolfItem\WolfItem;
use App\Service\WolfServiceV2;
use Illuminate\Console\Command;

class UpdateAllItems extends Command
{
    public const CHUNK_SIZE = 5;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-all-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update All Item By 1 day';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        /** @var WolfServiceV2 $wolfService */
        $wolfService = app(WolfServiceV2::class);
        $wolfService->updateAllItem();

        echo "Finish update all items. Here is preview of some items \n";
        $preview_items = WolfItem::query()->orderBy('id')->limit(20)->get();
        foreach ($preview_items as $item) {
            // Print current state of each item
            echo $item->toBaseItem() . "\n";
        }
    }
}
