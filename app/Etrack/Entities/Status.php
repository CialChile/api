<?php

namespace App\Etrack\Entities;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Entities\Company\Company;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Status
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $type can refer to an asset (0) or an document (1)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Status whereCreatedAt($value)
 * @method static Builder|Status whereDeletedAt($value)
 * @method static Builder|Status whereId($value)
 * @method static Builder|Status whereName($value)
 * @method static Builder|Status whereType($value)
 * @method static Builder|Status whereUpdatedAt($value)
 * @property int $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Asset[] $assets
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Status whereCompanyId($value)
 */
class Status extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['name', 'type'];
    protected $table = 'status';
    protected $casts = [
        'type' => 'integer'
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'status_id');
    }
}
