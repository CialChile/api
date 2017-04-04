<?php

namespace App\Etrack\Entities\Activity;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Activity extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [ 'company_id',
                            'program_type_id',
                            'measure_unit_id',
                            'template_id',
                            'number',
                            'name',
                            'description',
                            'process_type',
                            'stimated_time',
                            'start_date',
                            'end_date',
                            'start_hour',
                            'end_hour',
                            'validity'];

    protected $dates = ['start_date',
                        'end_date',
                        'deleted_at'];

}
