<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Company\Company;
use App\Etrack\Entities\Status;
use App\Etrack\Entities\Worker\Worker;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * App\Etrack\Entities\Assets\Asset
 *
 * @property int $id
 * @property int $company_id
 * @property int $worker_id
 * @property int $workplace_id
 * @property int $status_id
 * @property int $brand_id
 * @property int $model_id
 * @property int $category_id
 * @property int $sub_category_id
 * @property string $tag_rfid
 * @property string $location
 * @property string $sku
 * @property string $serial
 * @property string $image
 * @property int $validity_time
 * @property \Carbon\Carbon $integration_date
 * @property \Carbon\Carbon $end_service_life_date
 * @property \Carbon\Carbon $warranty_date
 * @property \Carbon\Carbon $disincorporation_date
 * @property array $custom_fields
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Etrack\Entities\Status $brand
 * @property-read \App\Etrack\Entities\Assets\Category $category
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @property-read \App\Etrack\Entities\Assets\BrandModel $model
 * @property-read \App\Etrack\Entities\Status $status
 * @property-read \App\Etrack\Entities\Assets\Subcategory $subcategory
 * @property-read \App\Etrack\Entities\Worker\Worker $worker
 * @method static Builder|BaseModel inCompany()
 * @method static Builder|Asset whereBrandId($value)
 * @method static Builder|Asset whereCategoryId($value)
 * @method static Builder|Asset whereCompanyId($value)
 * @method static Builder|Asset whereCreatedAt($value)
 * @method static Builder|Asset whereCustomFields($value)
 * @method static Builder|Asset whereDeletedAt($value)
 * @method static Builder|Asset whereDisincorporationDate($value)
 * @method static Builder|Asset whereEndServiceLifeDate($value)
 * @method static Builder|Asset whereId($value)
 * @method static Builder|Asset whereImage($value)
 * @method static Builder|Asset whereIntegrationDate($value)
 * @method static Builder|Asset whereLocation($value)
 * @method static Builder|Asset whereModelId($value)
 * @method static Builder|Asset whereSerial($value)
 * @method static Builder|Asset whereSku($value)
 * @method static Builder|Asset whereStatusId($value)
 * @method static Builder|Asset whereSubCategoryId($value)
 * @method static Builder|Asset whereTagRfid($value)
 * @method static Builder|Asset whereUpdatedAt($value)
 * @method static Builder|Asset whereValidityTime($value)
 * @method static Builder|Asset whereWarrantyDate($value)
 * @method static Builder|Asset whereWorkerId($value)
 * @method static Builder|Asset whereWorkplaceId($value)
 * @mixin \Eloquent
 * @property-read \App\Etrack\Entities\Assets\BrandModel $brandModel
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Worker\Worker[] $workers
 * @method static Builder|Asset whereName($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Media[] $media
 * @property-read \App\Etrack\Entities\Assets\Workplace $workplace
 */
class Asset extends BaseModel implements HasMediaConversions
{
    use HasMediaTrait;
    use SoftDeletes;
    protected $fillable = [
        'company_id', 'worker_id', 'status_id', 'workplace_id', 'brand_id', 'model_id', 'category_id',
        'sub_category_id', 'tag_rfid', 'location', 'sku', 'serial', 'validity_time',
        'integration_date', 'end_service_life_date', 'name',
        'warranty_date', 'disincorporation_date', 'custom_fields'
    ];

    protected $dates = [
        'integration_date', 'end_service_life_date', 'warranty_date',
        'disincorporation_date', 'deleted_at'
    ];

    protected $casts = [
        'company_id'      => 'integer',
        'worker_id'       => 'integer',
        'status_id'       => 'integer',
        'brand_id'        => 'integer',
        'model_id'        => 'integer',
        'category_id'     => 'integer',
        'sub_category_id' => 'integer',
        'custom_fields'   => 'array',
    ];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('large')
            ->fit(Manipulations::FIT_CONTAIN, 800, 450)
            ->performOnCollections('cover', 'images');

        $this->addMediaConversion('normal')
            ->fit(Manipulations::FIT_CONTAIN, 400, 225)
            ->performOnCollections('cover', 'images');

        $this->addMediaConversion('thumbnail')
            ->fit(Manipulations::FIT_CONTAIN, 133, 75)
            ->performOnCollections('cover', 'images');


    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function workers()
    {
        return $this->belongsToMany(Worker::class, 'assets_workers', 'asset_id', 'worker_id')->withPivot(['assign_date', 'unassign_date']);
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function brandModel()
    {
        return $this->belongsTo(BrandModel::class, 'model_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'sub_category_id');
    }

    public function workplace()
    {
        return $this->belongsTo(Workplace::class, 'workplace_id');
    }

    public function setIntegrationDateAttribute($value)
    {
        $this->attributes['integration_date'] = $this->getDate($value);
    }

    public function setEndServiceLifeDateAttribute($value)
    {
        $this->attributes['end_service_life_date'] = $this->getDate($value);
    }

    public function setWarrantyDateAttribute($value)
    {
        $this->attributes['warranty_date'] = $this->getDate($value);
    }

    public function setDisincorporationDateAttribute($value)
    {
        $this->attributes['disincorporation_date'] = $this->getDate($value);
    }

    private function getDate($value)
    {
        if ($value == 'null' || !$value) {
            return null;
        }

        if ($value instanceof Carbon) {
            return $value;
        }

        if (preg_match('/[0-9]+\/[0-9]+\/[0-9]+/', $value)) {
            return Carbon::createFromFormat('d/m/Y', $value);
        }

        return Carbon::parse($value);
    }

}
