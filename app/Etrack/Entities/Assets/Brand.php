<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Company\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Assets\Brand
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Brand whereCreatedAt($value)
 * @method static Builder|Brand whereDeletedAt($value)
 * @method static Builder|Brand whereId($value)
 * @method static Builder|Brand whereName($value)
 * @method static Builder|Brand whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Asset[] $assets
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Brand whereCompanyId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\BrandModel[] $brandModels
 */
class Brand extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['name', 'company_id'];

    protected $dates = [
        'deleted_at'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'brand_id');
    }

    public function brandModels()
    {
        return $this->hasMany(BrandModel::class, 'brand_id');
    }

}
