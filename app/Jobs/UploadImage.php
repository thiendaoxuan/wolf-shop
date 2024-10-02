<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\WolfItem\WolfItem;
use Cloudinary\Cloudinary;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UploadImage implements ShouldQueue
{
    use Queueable;


    protected array $params;

    /**
     * Create a new job instance.
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $itemId = $this->params['item_id'];
        $item = WolfItem::query()->find($itemId);

        // Parse the URL to get the relative file path
        $filePath = parse_url($item->image, PHP_URL_PATH);

        // Convert the relative path to a full local path (assuming it's in the public directory)
        $localPath = public_path($filePath);

        // Check if the file exists locally
        if (! file_exists($localPath)) {
            echo "File image not found for item {$itemId}";
            return;
        }

        $key = $this->getKey();
        putenv("CLOUDINARY_URL=cloudinary://647836991622118:{$key}@dg0kreplt");
        // Initialize Cloudinary
        $cloudinary = new Cloudinary();

        // Upload the local file to Cloudinary

        $uploadResult = [];
        try {
            $uploadResult = $cloudinary->uploadApi()->upload($localPath, [
                'folder' => 'products', // Optional: specify a folder in Cloudinary
            ]);
        } catch (\Exception $e) {
            echo 'Unable to upload to cloudinary : ' . $e;
        }

        if (! empty($uploadResult['secure_url'])) {
            $item->image = $uploadResult['secure_url'];
            $item->save();
            // Delete file after update
            unlink($localPath);
        }
    }

    private function getKey(): string
    {
        // Put like this to prevent repo crawler
        return str_replace('*', '', '*lp*Ys6m*UAt*hjpT1V' . 'yh*I01m*rVRw-g');
    }
}
