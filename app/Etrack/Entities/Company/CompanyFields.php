<?php

namespace App\Etrack\Entities\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Company\CompanyFields
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Company\Company[] $companies
 * @method static Builder|CompanyFields whereCreatedAt($value)
 * @method static Builder|CompanyFields whereId($value)
 * @method static Builder|CompanyFields whereName($value)
 * @method static Builder|CompanyFields whereUpdatedAt($value)
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
