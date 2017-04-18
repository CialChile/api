<?php

namespace App\Etrack\Entities\Certification;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * App\Etrack\Entities\Certification\CertificationWorkerAsset
 *
 * @property int $id
 * @property int $certification_id
 * @property string $start_date
 * @property string $end_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $certificable_id
 * @property string $certificable_type
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereCertificableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereCertificableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereCertificationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Certification\CertificationWorkerAsset whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 */
class CertificationWorkerAsset extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $table = 'certifications_workers_assets';
    protected $fillable = [];

}
