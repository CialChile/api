<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;

/**
 * App\Etrack\Entities\Assets\AssetConfiguration
 *
 * @property int $id
 * @property int $company_id
 * @property string $sku_type
 * @property string $sku_mask
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\AssetConfiguration whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\AssetConfiguration whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\AssetConfiguration whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\AssetConfiguration whereSkuMask($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\AssetConfiguration whereSkuType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\AssetConfiguration whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 */
class AssetConfiguration extends BaseModel
{

    protected $table = 'assets_configuration';
    protected $fillable = ['company_id', 'sku_type', 'sku_mask'];

}
