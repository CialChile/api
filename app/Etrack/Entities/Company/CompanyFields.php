<?php

namespace App\Etrack\Entities\Company;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * App\Etrack\Entities\Company\CompanyFields
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Company\Company[] $companies
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\CompanyFields whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\CompanyFields whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\CompanyFields whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\CompanyFields whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CompanyFields extends Model
{

    protected $table = 'company_fields';
    protected $fillable = ['name'];

    public function companies()
    {
        return $this->hasMany(Company::class, 'field_id');
    }

}
