<?php

declare(strict_types=1);

namespace App\Models\WolfItem;

use App\Models\BaseClass\Item;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property int $sell_in
 * @property int $quality
 */
class WolfItem extends Model
{
    protected $table = 'wolf_items';

    protected $fillable = ['name', 'sell_in', 'quality'];
    
    protected const MAX_QUALITY = 50;

    protected const MIN_QUALITY = 0;
    
    public function updateByOneDay(): void
    {
        $this->sell_in--;
        if ($this->sell_in < 0) {
            $this->decreaseQuality(2);
        } else {
            $this->decreaseQuality(1);
        }
    }

    protected function decreaseQuality($amount): void
    {
        $this->quality = max(self::MIN_QUALITY, $this->quality - $amount);
    }

    protected function increaseQuality($amount): void
    {
        $this->quality = min(self::MAX_QUALITY, $this->quality + $amount);
    }
    
    public function toBaseItem(): Item
    {
        return new Item(
            $this->name,
            $this->sell_in,
            $this->quality
        );
    }
}
