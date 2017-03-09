<?php

namespace App\Etrack\Entities\Auth;

use App\Etrack\Entities\Company\Company;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Acl\Traits\HasRole;

/**
 * App\Etrack\Entities\Auth\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Kodeine\Acl\Models\Eloquent\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Auth\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User role($role, $column = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $active
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereActive($value)
 * @property int $company_id
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereCompanyId($value)
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property string $rut_passport
 * @property string $position
 * @property \Carbon\Carbon $birthday
 * @property string $address
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $telephone
 * @property string $emergency_telephone
 * @property string $emergency_contact
 * @property string $medical_information
 * @property bool $company_admin
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereCompanyAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereEmergencyContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereEmergencyTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereMedicalInformation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereRutPassport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereTelephone($value)
 */
class User extends Authenticatable
{
    use Notifiable, HasRole;


    protected $casts = [
        'active'        => 'boolean',
        'company_id'    => 'integer',
        'company_admin' => 'boolean'
    ];
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'active', 'company_id',
        'company_admin', 'medical_information', 'emergency_contact', 'emergency_telephone',
        'telephone', 'city', 'state', 'country', 'address', 'birthday', 'position', 'rut_passport'
    ];

    protected $dates = ['birthday'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isSuperUser()
    {
        return $this->hasRole('administrator') && $this->company_id == null;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
