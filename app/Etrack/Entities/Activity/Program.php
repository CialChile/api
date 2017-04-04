<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Program extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = ['frequency_id','periodicity_id','name'];

    protected $dates = ['deleted_at'];

}
