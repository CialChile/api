<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Activity\ProgramType
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ProgramType whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ProgramType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ProgramType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ProgramType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ProgramType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Activity\ProgramType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 */
class ProgramType extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['company_id','name'];

    protected $dates = ['deleted_at'];

}
