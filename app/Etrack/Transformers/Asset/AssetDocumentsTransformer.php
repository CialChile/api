<?php
namespace App\Etrack\Transformers\Asset;

use League\Fractal\TransformerAbstract;
use Spatie\MediaLibrary\Media;

class AssetDocumentsTransformer extends TransformerAbstract
{

    public function transform(Media $model)
    {
        return [
            'id'        => $model->id,
            'name'      => $model->file_name,
            'mime_type' => $model->mime_type,
            'size'      => $this->formatBytes($model->size)
        ];
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        // $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}