<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;

class AssetConfiguration extends BaseModel
{

    protected $table = 'assets_configuration';
    protected $fillable = ['company_id', 'sku_type', 'sku_mask'];

}
