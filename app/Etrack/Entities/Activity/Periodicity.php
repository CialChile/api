<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Periodicity extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [ 'company_id',
                            'times',
                            'description'];

    protected $dates = ['deleted_at'];

}
