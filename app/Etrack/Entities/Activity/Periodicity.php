<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Activity\Periodicity
 *
 * @property int $id
 * @property int $company_id
 * @property int $times
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Periodicity whereCompanyId($value)
 * @method static Builder|Periodicity whereCreatedAt($value)
 * @method static Builder|Periodicity whereDeletedAt($value)
 * @method static Builder|Periodicity whereDescription($value)
 * @method static Builder|Periodicity whereId($value)
 * @method static Builder|Periodicity whereTimes($value)
 * @method static Builder|Periodicity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static Builder|BaseModel inCompany()
 */
class Periodicity extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [ 'company_id',
                            'times',
                            'description'];

    protected $dates = ['deleted_at'];

}
