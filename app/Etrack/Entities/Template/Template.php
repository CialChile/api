<?php

namespace App\Etrack\Entities\Template;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Template extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;

    protected $fillable = [ 'company_id',
                            'template_type_id',
                            'program_type_id',
                            'measure_unit_id',
                            'frequency_id',
                            'periodicity_id',
                            'name_template',
                            'name_activity',
                            'description_activity',
                            'execution_stimated_time'];

    protected $dates = ['deleted_at'];

}
