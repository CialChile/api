<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Periodicity whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Periodicity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Periodicity whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Periodicity whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Periodicity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Periodicity whereTimes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Periodicity whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 */
class Periodicity extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [ 'company_id',
                            'times',
                            'description'];

    protected $dates = ['deleted_at'];

}
