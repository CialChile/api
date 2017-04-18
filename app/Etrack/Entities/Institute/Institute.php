<?php

namespace App\Etrack\Entities\Institute;

use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Certification\Certification;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Institute\Institute
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property string $rut
 * @property string $address
 * @property string $city
 * @property string $contact
 * @property string $telephone_contact
 * @property string $email_contact
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Certification\Certification[] $certifications
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereEmailContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereRut($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereTelephoneContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $country
 * @property string $state
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Institute\Institute whereState($value)
 */
class Institute extends BaseModel
{
    use SoftDeletes;

    protected $casts = [
        'company_id' => 'integer'
    ];

    protected $fillable = [
        'company_id', 'name', 'rut', 'address', 'city', 'country', 'state',
        'contact', 'telephone_contact', 'email_contact'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

}
