<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Company\Company;
use App\Etrack\Entities\Status;
use App\Etrack\Entities\Worker\Worker;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

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
 */
class Asset extends BaseModel
{

    use SoftDeletes;
    protected $fillable = [
        'company_id', 'worker_id', 'status_id', 'brand_id', 'model_id', 'category_id',
        'sub_category_id', 'tag_rfid', 'location', 'sku', 'serial', 'validity_time',
        'integration_date', 'end_service_life_date',
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class, 'worker_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function brand()
    {
        return $this->belongsTo(Status::class, 'brand_id');
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

}
