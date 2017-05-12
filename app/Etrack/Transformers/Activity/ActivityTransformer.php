<?php

namespace App\Etrack\Transformers\Activity;

use App\Etrack\Entities\Activity\ActivityObservation;
use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Etrack\Transformers\Auth\UserTransformer;
use App\Etrack\Transformers\Company\CompanyTransformer;
use App\Etrack\Transformers\Template\TemplateTransformer;
use League\Fractal\TransformerAbstract;
use App\Etrack\Entities\Activity\Activity;

/**
 * Class ActivityTransformer
 * @package namespace App\Etrack\Transformers\Activity;
 */
class ActivityTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'company',
        'programType',
        'template',
        'equipmentList',
        'proceduresList',
        'supervisor',
        'createdBy',
        'observations',
        'assets',
        'schedules'
    ];

    /**
     * Transform the \Activity entity
     * @param Activity $model
     *
     * @return array
     */
    public function transform(Activity $model)
    {
        return [
            'id'                  => (int)$model->id,
            'company_id'          => $model->company_id,
            'program_type_id'     => $model->program_type_id,
            'template_id'         => $model->template_id,
            'supervisor_id'       => $model->supervisor_id,
            'name'                => $model->name,
            'description'         => $model->description,
            'estimated_time'      => $model->estimated_time,
            'estimated_time_unit' => $model->estimated_time_unit,
            'created_at'          => $model->created_at ? $model->created_at->format('d/m/Y') : null,
            'updated_at'          => $model->updated_at ? $model->updated_at->format('d/m/Y') : null,
        ];
    }

    public function includeCompany(Activity $model)
    {
        return $this->item($model->company, new CompanyTransformer(), 'parent');
    }

    public function includeProgramType(Activity $model)
    {
        return $this->item($model->programType, new ProgramTypeTransformer(), 'parent');

    }

    public function includeTemplate(Activity $model)
    {
        return $this->item($model->template, new TemplateTransformer(), 'parent');

    }

    public function includeSupervisor(Activity $model)
    {
        if ($model->supervisor) {
            return $this->item($model->supervisor, new UserTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeCreatedBy(Activity $model)
    {
        if ($model->createdBy) {
            return $this->item($model->createdBy, new UserTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeProceduresList(Activity $model)
    {
        if ($model->procedures) {
            return $this->collection($model->procedures, new ActivityProceduresTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeEquipmentList(Activity $model)
    {
        if ($model->materials) {
            return $this->collection($model->materials, new ActivityMaterialsTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeAssets(Activity $model)
    {
        if ($model->assets) {
            return $this->collection($model->assets, new AssetTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeSchedules(Activity $model)
    {
        if ($model->schedules) {
            return $this->collection($model->schedules, new ActivityScheduleTransformer(), 'parent');
        }

        return $this->null();
    }

    public function includeObservations(Activity $model)
    {
        if ($model->observations) {
            return $this->collection($model->observations, function (ActivityObservation $observation) {
                return [
                    'observation' => $observation->observation
                ];
            }, 'parent');
        }

        return $this->null();
    }

}
