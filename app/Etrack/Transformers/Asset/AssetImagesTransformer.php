<?php
namespace App\Etrack\Transformers\Asset;

use League\Fractal\TransformerAbstract;
use Spatie\MediaLibrary\Media;

class AssetImagesTransformer extends TransformerAbstract
{

    public function transform(Media $model)
    {
        return [
            'id'        => $model->id,
            'normal'    => env('APP_URL') . $model->getUrl('normal'),
            'thumbnail' => env('APP_URL') . $model->getUrl('thumbnail'),
            'source'    => env('APP_URL') . $model->getUrl('large'),
            'original'  => env('APP_URL') . $model->getUrl(),
            'title'     => $model->name
        ];
    }
}