<?php

namespace App\Etrack\Entities\Auth;

use App\Etrack\Entities\Company\Company;
use App\Etrack\Entities\Worker\Worker;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
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
 * @method static Builder|User role($role, $column = null)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property bool $active
 * @method static Builder|User whereActive($value)
 * @property int $company_id
 * @method static Builder|User whereCompanyId($value)
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
 * @method static Builder|User whereAddress($value)
 * @method static Builder|User whereBirthday($value)
 * @method static Builder|User whereCity($value)
 * @method static Builder|User whereCompanyAdmin($value)
 * @method static Builder|User whereCountry($value)
 * @method static Builder|User whereEmergencyContact($value)
 * @method static Builder|User whereEmergencyTelephone($value)
 * @method static Builder|User whereMedicalInformation($value)
 * @method static Builder|User wherePosition($value)
 * @method static Builder|User whereRutPassport($value)
 * @method static Builder|User whereState($value)
 * @method static Builder|User whereTelephone($value)
 * @property int $worker_id
 * @property-read \App\Etrack\Entities\Worker\Worker $worker
 * @method static Builder|User whereWorkerId($value)
 * @method static Builder|User inCompany()
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|User whereDeletedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User hasCertifications($certificationsIds)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User hasPositions($positions)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User hasQueryRoles($roles)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Auth\User hasSpecialties($specialties)
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
        $adminRoles = Role::where('slug', 'like', 'admin-%')->where('company_id', 0)->get();
        $roles = $adminRoles->pluck('slug');
        return $this->hasRole($roles->toArray(), 'or') && $this->company_id == null;
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
        /** @var Builder $query */
        return $query->where('company_id', $company_id);
    }

    public function scopeHasQueryRoles($query, $roles)
    {
        $roles = $this->hasDelimiterToArray($roles);
        if (is_array($roles)) {
            return $query->where(function ($q) use ($roles) {
                foreach ($roles as $index => $role) {
                    $q = !$index ? $q->whereHas('roles', function ($q2) use ($role) {
                        return $q2->where('slug', $role);
                    }) : $q->orWhereHas('roles', function ($q2) use ($role) {
                        return $q2->where('slug', $role);
                    });
                }
                return $q;
            });
        }

        return $query->whereHas('roles', function ($q2) use ($roles) {
            return $q2->where('slug', $roles);
        });
    }

    public function scopeHasCertifications($query, $certificationsIds)
    {
        $certificationsIds = $this->hasDelimiterToArray($certificationsIds);
        if (is_array($certificationsIds)) {
            return $query->where(function ($q) use ($certificationsIds) {
                foreach ($certificationsIds as $index => $certificationId) {
                    $q = $q->whereHas('worker.certifications', function ($q2) use ($certificationId) {
                        return $q2->where('certifications.id', $certificationId);
                    });
                }
                return $q;
            });
        }

        return $query->whereHas('worker.certifications', function ($q2) use ($certificationsIds) {
            return $q2->where('certifications.id', $certificationsIds);
        });
    }

    public function scopeHasPositions($query, $positions)
    {
        $positions = $this->hasDelimiterToArray($positions);
        if (is_array($positions)) {
            return $query->where(function ($q) use ($positions) {
                foreach ($positions as $index => $position) {
                    $q = !$index ? $q->whereHas('worker', function ($q2) use ($position) {
                        return $q2->where('workers.position', $position);
                    }) : $q->orWhereHas('worker', function ($q2) use ($position) {
                        return $q2->where('workers.position', $position);
                    });
                }
                return $q;
            });
        }

        return $query->whereHas('worker', function ($q2) use ($positions) {
            return $q2->where('workers.position', $positions);
        });
    }

    public function scopeHasSpecialties($query, $specialties)
    {
        $specialties = $this->hasDelimiterToArray($specialties);
        if (is_array($specialties)) {
            return $query->where(function ($q) use ($specialties) {
                foreach ($specialties as $index => $specialty) {
                    $q = !$index ? $q->whereHas('worker', function ($q2) use ($specialty) {
                        return $q2->where('workers.specialty', $specialty);
                    }) : $q->orWhereHas('worker', function ($q2) use ($specialty) {
                        return $q2->where('workers.specialty', $specialty);
                    });
                }
                return $q;
            });
        }
        return $query->whereHas('worker', function ($q2) use ($specialties) {
            return $q2->where('workers.specialty', $specialties);
        });
    }
}
