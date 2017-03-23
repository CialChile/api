<?php

namespace App\Etrack\Entities\Assets;

use App\Etrack\Entities\Company\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Assets\Subcategory
 *
 * @property-read \App\Etrack\Entities\Assets\Category $category
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Etrack\Entities\Assets\Asset[] $assets
 * @property-read \App\Etrack\Entities\Company\Company $company
 */
class Subcategory extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'category_id'];

    protected $dates = [
        'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function assets()
    {
        return $this->hasMany(Asset::class, 'sub_category_id');
    }
}
