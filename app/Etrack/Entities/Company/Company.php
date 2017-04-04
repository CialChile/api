<?php

namespace App\Etrack\Entities\Company;

use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Worker\Worker;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Company\Company
 *
 * @property int $id
 * @property int $field_id
 * @property string $name
 * @property string $commercial_name
 * @property string $fiscal_identification
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $zip_code
 * @property string $address
 * @property string $email
 * @property string $telephone
 * @property string $fax
 * @property bool $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \App\Etrack\Entities\Company\CompanyFields $field
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Auth\User[] $users
 * @method static Builder|Company whereActive($value)
 * @method static Builder|Company whereAddress($value)
 * @method static Builder|Company whereCity($value)
 * @method static Builder|Company whereCommercialName($value)
 * @method static Builder|Company whereCountry($value)
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereDeletedAt($value)
 * @method static Builder|Company whereEmail($value)
 * @method static Builder|Company whereFax($value)
 * @method static Builder|Company whereFieldId($value)
 * @method static Builder|Company whereFiscalIdentification($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereState($value)
 * @method static Builder|Company whereTelephone($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @method static Builder|Company whereZipCode($value)
 * @mixin \Eloquent
 * @property int $users_number
 * @method static Builder|Company whereUsersNumber($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Worker\Worker[] $workers
 * @method static Builder|BaseModel inCompany()
 * @property-read Company $company
 */
class Company extends BaseModel
{
    use SoftDeletes;

    protected $casts = [
        'active' => 'boolean'
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $fillable = [
        'name',
        'active',
        'field_id',
        'commercial_name',
        'fiscal_identification',
        'country',
        'state',
        'city',
        'zip_code',
        'address',
        'email',
        'telephone',
        'fax',
        'users_number'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function field()
    {
        return $this->belongsTo(CompanyFields::class, 'field_id');
    }

    public function workers()
    {
        return $this->hasMany(Worker::class, 'company_id');
    }

}
