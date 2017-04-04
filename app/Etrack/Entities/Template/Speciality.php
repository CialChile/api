<?php

namespace App\Etrack\Entities\Template;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Template\Speciality
 *
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static Builder|BaseModel inCompany()
 */
class Speciality extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['company_id','name'];

    protected $dates = ['deleted_at'];

}
