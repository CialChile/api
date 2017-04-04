<?php

namespace App\Etrack\Entities\Template;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Template\TemplateType
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\TemplateType whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\TemplateType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\TemplateType whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\TemplateType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\TemplateType whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Template\TemplateType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @property-read \App\Etrack\Entities\Company\Company $company
 */
class TemplateType extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['company_id','name'];

    protected $dates = ['deleted_at'];

}
