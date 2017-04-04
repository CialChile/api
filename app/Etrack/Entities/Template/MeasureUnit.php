<?php

namespace App\Etrack\Entities\Template;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class MeasureUnit extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

}
