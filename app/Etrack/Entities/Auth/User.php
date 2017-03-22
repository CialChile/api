<?php

namespace App\Etrack\Entities\Auth;

use App\Etrack\Entities\Company\Company;
use App\Etrack\Entities\Worker\Worker;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Acl\Traits\HasRole;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

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
 * @property int $worker_id
 * @property-read \App\Etrack\Entities\Worker\Worker $worker
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereWorkerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User inCompany()
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User whereDeletedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 */
class User extends Authenticatable implements HasMediaConversions
{
    use Notifiable, HasRole, SoftDeletes, HasMediaTrait;

    protected $dates = ['deleted_at'];

    protected $casts = [
        'active'        => 'boolean',
        'company_id'    => 'integer',
        'company_admin' => 'boolean',
        'worker_id'     => 'integer'
    ];

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'active', 'company_id',
        'company_admin', 'worker_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('normal')
            ->fit(Manipulations::FIT_CONTAIN, 300, 400)
            ->performOnCollections('profile');

        $this->addMediaConversion('small')
            ->fit(Manipulations::FIT_CONTAIN, 100, 133)
            ->performOnCollections('profile');

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->performOnCollections('profile');
    }

    public function isSuperUser()
    {
        return $this->hasRole('administrator') && $this->company_id == null;
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function scopeInCompany($query)
    {
        $company_id = \Auth::user()->company_id;
        return $query->where('company_id', $company_id);
    }
}
