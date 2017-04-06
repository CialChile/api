<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Company\Company;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Assets\Workplace
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|BaseModel inCompany()
 * @method static Builder|Workplace whereCompanyId($value)
 * @method static Builder|Workplace whereCreatedAt($value)
 * @method static Builder|Workplace whereDeletedAt($value)
 * @method static Builder|Workplace whereId($value)
 * @method static Builder|Workplace whereName($value)
 * @method static Builder|Workplace whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Asset[] $assets
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property string $longitude
 * @property string $latitude
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Workplace whereLatitude($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Workplace whereLongitude($value)
 */
class Workplace extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['name', 'company_id', 'latitude', 'longitude'];

    protected $dates = [
        'deleted_at'
    ];

    protected $casts = [
        'latitude'  => 'decimal',
        'longitude' => 'decimal'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'workplace_id');
    }

}
