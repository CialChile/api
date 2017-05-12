<?php

namespace App\Etrack\Entities\Worker;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Certification\Certification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Venturecraft\Revisionable\RevisionableTrait;

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
 * @method static Builder|Worker whereAddress($value)
 * @method static Builder|Worker whereBirthday($value)
 * @method static Builder|Worker whereCity($value)
 * @method static Builder|Worker whereCompanyId($value)
 * @method static Builder|Worker whereCountry($value)
 * @method static Builder|Worker whereCreatedAt($value)
 * @method static Builder|Worker whereDeletedAt($value)
 * @method static Builder|Worker whereEmail($value)
 * @method static Builder|Worker whereEmergencyContact($value)
 * @method static Builder|Worker whereEmergencyTelephone($value)
 * @method static Builder|Worker whereFirstName($value)
 * @method static Builder|Worker whereId($value)
 * @method static Builder|Worker whereLastName($value)
 * @method static Builder|Worker whereMedicalInformation($value)
 * @method static Builder|Worker wherePosition($value)
 * @method static Builder|Worker whereRutPassport($value)
 * @method static Builder|Worker whereState($value)
 * @method static Builder|Worker whereTelephone($value)
 * @method static Builder|Worker whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static Builder|BaseModel inCompany()
 * @property bool $active
 * @method static Builder|Worker whereActive($value)
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Auth\User $user
 * @property string $zip_code
 * @method static Builder|Worker whereZipCode($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @property-read \Illuminate\Database\Eloquent\Collection|\Venturecraft\Revisionable\Revision[] $revisionHistory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Asset[] $assets
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Certification\Certification[] $certifications
 * @property string $specialty
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereSpecialty($value)
 * @property int $creator_id
 * @property-read \App\Etrack\Entities\Auth\User $createdBy
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Worker\Worker whereCreatorId($value)
 */
class Worker extends BaseModel implements HasMediaConversions
{
    use HasMediaTrait;
    use SoftDeletes;
    use RevisionableTrait;
    protected $casts = [
        'company_id' => 'integer',
        'active'     => 'boolean'
    ];

    protected $fillable = [
        'company_id', 'first_name', 'last_name', 'emergency_contact', 'creator_id',
        'emergency_telephone', 'telephone', 'city', 'state', 'zip_code', 'medical_information',
        'country', 'address', 'birthday', 'position', 'rut_passport', 'email', 'active', 'specialty'
    ];
    protected $dates = ['birthday', 'deleted_at'];

    protected $revisionEnabled = true;
    protected $revisionCreationsEnabled = true;
    protected $dontKeepRevisionOf = array(
        'birthday'
    );

    public function registerMediaConversions()
    {

        $this->addMediaConversion('large')
            ->fit(Manipulations::FIT_CONTAIN, 600, 800)
            ->performOnCollections('profile');

        $this->addMediaConversion('normal')
            ->fit(Manipulations::FIT_CONTAIN, 300, 400)
            ->performOnCollections('profile');

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CONTAIN, 200, 267)
            ->performOnCollections('profile');


    }

    public function user()
    {
        return $this->hasOne(User::class, 'worker_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'worker_id');
    }

    public function certifications()
    {
        return $this->morphToMany(Certification::class, 'certificable', 'certifications_workers_assets')->withPivot('start_date', 'end_date', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

}
