<?php

namespace App\Etrack\Entities\Certification;

use App\Etrack\Entities\Assets\Asset;
use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Institute\Institute;
use App\Etrack\Entities\Status;
use App\Etrack\Entities\Worker\Worker;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

/**
 * App\Etrack\Entities\Certification\Certification
 *
 * @property int $id
 * @property int $company_id
 * @property int $institute_id
 * @property int $certification_type_id
 * @property int $status_id
 * @property string $sku
 * @property string $name
 * @property string $description
 * @property int $validity_time
 * @property bool $validity
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Institute\Institute $institute
 * @property-read \App\Etrack\Entities\Status $status
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereCertificationTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereInstituteId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereSku($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereStatusId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereValidity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereValidityTime($value)
 * @mixin \Eloquent
 * @property int $validity_time_unit 0:dias,1:meses,2:años
 * @property int $type 0:Activo,1:trabajador,2:ambos
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\Certification whereValidityTimeUnit($value)
 */
class Certification extends BaseModel implements HasMedia
{
    use HasMediaTrait;
    use SoftDeletes;

    protected $casts = [
        'company_id'         => 'integer',
        'institute_id'       => 'integer',
        'status_id'          => 'integer',
        'validity'           => 'boolean',
        'validity_time'      => 'integer',
        'validity_time_unit' => 'integer',
        'type'               => 'integer',
    ];

    protected $fillable = [
        'company_id', 'institute_id', 'type', 'status_id',
        'sku', 'name', 'description', 'validity_time', 'validity', 'validity_time_unit'
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function assets()
    {
        return $this->morphedByMany(Asset::class, 'certificable', 'certifications_workers_assets')->withPivot('start_date', 'end_date');
    }

    public function workers()
    {
        return $this->morphedByMany(Worker::class, 'certificable', 'certifications_workers_assets')->withPivot('start_date', 'end_date', 'id');
    }

    public function institute()
    {
        return $this->belongsTo(Institute::class);
    }

}
