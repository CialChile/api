<?php

namespace App\Etrack\Entities\Assets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Etrack\Entities\Assets\Subcategory
 *
 * @property-read \App\Etrack\Entities\Assets\Category $category
 * @mixin \Eloquent
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
}
