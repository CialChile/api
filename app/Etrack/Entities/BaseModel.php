<?php
namespace App\Etrack\Entities;

use App\Etrack\Entities\Company\Company;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\BaseModel
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Company\Company $company
 */
class BaseModel extends Model
{

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function scopeInCompany($query)
    {
        $company_id = \Auth::user()->company_id;
        return $query->where($this->getTable() . '.company_id', $company_id);
    }

}