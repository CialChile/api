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

    private function formatBytes($bytes, $force_unit = NULL, $format = NULL, $si = TRUE)
    {
        // Format string
        $format = ($format === NULL) ? '%01.2f %s' : (string)$format;

        // IEC prefixes (binary)
        if ($si == FALSE OR strpos($force_unit, 'i') !== FALSE) {
            $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
            $mod = 1024;
        } // SI prefixes (decimal)
        else {
            $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            $mod = 1000;
        }

        // Determine unit to use
        if (($power = array_search((string)$force_unit, $units)) === FALSE) {
            $power = ($bytes > 0) ? floor(log($bytes, $mod)) : 0;
        }

        return sprintf($format, $bytes / pow($mod, $power), $units[$power]);
    }
}