<?php

namespace App\Etrack\Entities\Template;

use App\Etrack\Entities\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Template\TemplateType
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|TemplateType whereCompanyId($value)
 * @method static Builder|TemplateType whereCreatedAt($value)
 * @method static Builder|TemplateType whereDeletedAt($value)
 * @method static Builder|TemplateType whereId($value)
 * @method static Builder|TemplateType whereName($value)
 * @method static Builder|TemplateType whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|BaseModel inCompany()
 * @property-read \App\Etrack\Entities\Company\Company $company
 */
class TemplateType extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['company_id','name'];

    protected $dates = ['deleted_at'];

}
