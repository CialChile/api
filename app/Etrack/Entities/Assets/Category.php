<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\BaseModel;
use App\Etrack\Entities\Company\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Assets\Category
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static Builder|Category whereCreatedAt($value)
 * @method static Builder|Category whereDeletedAt($value)
 * @method static Builder|Category whereId($value)
 * @method static Builder|Category whereName($value)
 * @method static Builder|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $company_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Asset[] $assets
 * @property-read \App\Etrack\Entities\Company\Company $company
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\BaseModel inCompany()
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Category whereCompanyId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Subcategory[] $subcategories
 * @property array $custom_fields_config
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Category whereCustomFieldsConfig($value)
 */
class Category extends BaseModel
{
    use SoftDeletes;
    protected $fillable = ['name', 'company_id','custom_fields_config'];
    protected $casts = [
        'custom_fields_config' => 'array',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'category_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

}
