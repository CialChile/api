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
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Subcategory whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Subcategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Subcategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Subcategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Subcategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Etrack\Entities\Assets\Subcategory whereUpdatedAt($value)
 */
class Subcategory extends Model
{
    use SoftDeletes;

    protected $table = 'sub_categories';
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
