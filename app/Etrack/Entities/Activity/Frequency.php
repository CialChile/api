<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Activity\Frequency
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Frequency whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Frequency whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Frequency whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Frequency whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Frequency whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Frequency whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\Frequency whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 */
class Frequency extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['company_id',
                           'name',
                           'description'];
    protected $dates = ['deleted_at'];
}
