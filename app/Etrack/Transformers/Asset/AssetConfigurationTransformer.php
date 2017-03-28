<?php

namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Assets\AssetConfiguration;
use League\Fractal\TransformerAbstract;

/**
 * Class AssetConfigurationTransformer
 * @package namespace App\Etrack\Transformers\Asset;
 */
class AssetConfigurationTransformer extends TransformerAbstract
{

    /**
     * Transform the \AssetConfiguration entity
     * @param AssetConfiguration $model
     *
     * @return array
     */
    public function transform(AssetConfiguration $model)
    {
        return [
            'id'       => (int)$model->id,
            'sku_type' => $model->sku_type,
            'sku_mask' => $model->sku_mask,
        ];
    }
}
