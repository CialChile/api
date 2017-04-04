<?php

namespace App\Etrack\Entities\Template;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Template\Position
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Position whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Position whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Position whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Position whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\Position whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 */
class Position extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['company_id','name'];

    protected $dates = ['deleted_at'];

}
