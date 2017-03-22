<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;
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
 */
class Workplace extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['name', 'company_id'];

    protected $dates = [
        'deleted_at'
    ];

}
