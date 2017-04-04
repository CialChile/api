<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Assets\AssetConfiguration
 *
 * @property int $id
 * @property int $company_id
 * @property string $sku_type
 * @property string $sku_mask
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Builder|BaseModel inCompany()
 * @method static Builder|AssetConfiguration whereCompanyId($value)
 * @method static Builder|AssetConfiguration whereCreatedAt($value)
 * @method static Builder|AssetConfiguration whereId($value)
 * @method static Builder|AssetConfiguration whereSkuMask($value)
 * @method static Builder|AssetConfiguration whereSkuType($value)
 * @method static Builder|AssetConfiguration whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 */
class AssetConfiguration extends BaseModel
{

    protected $table = 'assets_configuration';
    protected $fillable = ['company_id', 'sku_type', 'sku_mask'];

}
