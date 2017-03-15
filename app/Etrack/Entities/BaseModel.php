<?php
namespace App\Etrack\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\BaseModel
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{

    public function scopeInCompany($query)
    {
        $company_id = \Auth::user()->company_id;
        return $query->where('company_id', $company_id);
    }

}