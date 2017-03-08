<?php

namespace App\Etrack\Entities\Company;

use App\Etrack\Entities\Auth\User;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Etrack\Entities\Company\Company
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Auth\User[] $users
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property bool $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereUpdatedAt($value)
 * @property int $user_id
 * @property int $field_id
 * @property string $commercial_name
 * @property string $fiscal_identification
 * @property int $country_id
 * @property string $state
 * @property string $city
 * @property string $zip_code
 * @property string $address
 * @property string $email
 * @property string $telephone
 * @property string $fax
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereCommercialName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereFieldId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereFiscalIdentification($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereZipCode($value)
 * @property string $country
 * @property-read \App\Etrack\Entities\Company\CompanyFields $field
 * @property-read \App\Etrack\Entities\Auth\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Company\Company whereCountry($value)
 */
class Company extends Model
{
    protected $casts = [
        'active' => 'boolean'
    ];

    protected $fillable = [
        'name',
        'active'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    public function field()
    {
        return $this->belongsTo(CompanyFields::class, 'field_id');
    }



}
