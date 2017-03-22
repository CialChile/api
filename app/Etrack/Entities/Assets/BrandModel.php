<?php

namespace App\Etrack\Entities\Assets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;

/**
 * App\Etrack\Entities\Assets\BrandModel
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Etrack\Entities\Assets\Brand $brand
 * @method static Builder|BrandModel whereBrandId($value)
 * @method static Builder|BrandModel whereCreatedAt($value)
 * @method static Builder|BrandModel whereDeletedAt($value)
 * @method static Builder|BrandModel whereId($value)
 * @method static Builder|BrandModel whereName($value)
 * @method static Builder|BrandModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BrandModel extends Model
{
    use SoftDeletes;
    protected $table = 'model';
    protected $fillable = ['name', 'brand_id'];

    protected $dates = [
        'deleted_at'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
