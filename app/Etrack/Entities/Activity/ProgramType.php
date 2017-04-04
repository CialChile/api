<?php

namespace App\Etrack\Entities\Activity;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Activity\ProgramType
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|ProgramType whereCompanyId($value)
 * @method static Builder|ProgramType whereCreatedAt($value)
 * @method static Builder|ProgramType whereDeletedAt($value)
 * @method static Builder|ProgramType whereId($value)
 * @method static Builder|ProgramType whereName($value)
 * @method static Builder|ProgramType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static Builder|BaseModel inCompany()
 */
class ProgramType extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['company_id','name'];

    protected $dates = ['deleted_at'];

}
