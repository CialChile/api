<?php

namespace App\Etrack\Entities\Worker;

use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Company\Company;
use App\Etrack\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * App\Etrack\Entities\Worker\Worker
 *
 * @property int $id
 * @property int $company_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $rut_passport
 * @property \Carbon\Carbon $birthday
 * @property string $position
 * @property string $address
 * @property string $country
 * @property string $state
 * @property string $city
 * @property string $telephone
 * @property string $emergency_telephone
 * @property string $emergency_contact
 * @property string $medical_information
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereBirthday($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereCountry($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereEmergencyContact($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereEmergencyTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereMedicalInformation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereRutPassport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @property bool $active
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereActive($value)
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Auth\User $user
 * @property string $zip_code
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereZipCode($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 */
class Worker extends BaseModel implements HasMediaConversions
{
    use HasMediaTrait;
    use SoftDeletes;
    protected $casts = [
        'company_id' => 'integer',
        'active'     => 'boolean'
    ];

    protected $fillable = [
        'company_id', 'first_name', 'last_name', 'emergency_contact',
        'emergency_telephone', 'telephone', 'city', 'state', 'zip_code', 'medical_information',
        'country', 'address', 'birthday', 'position', 'rut_passport', 'email', 'active'
    ];
    protected $dates = ['birthday', 'deleted_at'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('normal')
            ->fit(Manipulations::FIT_CONTAIN, 300, 400)
            ->performOnCollections('profile');

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CONTAIN, 100, 133)
            ->performOnCollections('profile');


    }

    public function user()
    {
        return $this->hasOne(User::class, 'worker_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
