<?php
namespace App\Etrack\Transformers\Certification;

use App\Etrack\Entities\Certification\Certification;
use App\Etrack\Transformers\Asset\AssetTransformer;
use App\Etrack\Transformers\Institute\InstituteTransformer;
use App\Etrack\Transformers\StatusTransformer;
use App\Etrack\Transformers\Worker\WorkerTransformer;
use League\Fractal\TransformerAbstract;

class CertificationTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'institute',
        'assets',
        'workers',
        'status'
    ];


    public function transform(Certification $model)
    {
        $validityTimeUnits = ['Dias', 'Meses', 'Años'];
        $types = ['Activo', 'Trabajador', 'Activos y Trabajadores'];
        return [
            'id'                      => $model->id,
            'company_id'              => $model->company_id,
            'institute_id'            => $model->institute_id,
            'status_id'               => $model->status_id,
            'sku'                     => $model->sku,
            'name'                    => $model->name,
            'description'             => $model->description,
            'validity_time'           => $model->validity_time,
            'validity_time_formatted' => $model->validity_time . ' (' . $validityTimeUnits[$model->validity_time_unit] . ')',
            'validity_time_unit'      => $model->validity_time_unit,
            'validity'                => $model->validity,
            'type'                    => (string)$model->type,
            'typeName'                => $types[$model->type],
        ];
    }

    public function includeInstitute(Certification $model)
    {
        $institute = $model->institute;
        if ($institute) {
            return $this->item($institute, new InstituteTransformer(), 'parent');
        }

    }

    public function includeStatus(Certification $model)
    {
        $status = $model->status;
        if ($status) {
            return $this->item($status, new StatusTransformer(), 'parent');
        }

    }

    public function includeAssets(Certification $model)
    {
        $assets = $model->assets;
        if ($assets) {
            return $this->collection($assets, new AssetTransformer(), 'parent');
        }

        return $this->null();

    }

    public function includeWorkers(Certification $model)
    {
        $workers = $model->workers;
        if ($workers) {
            return $this->collection($workers, new WorkerTransformer(), 'parent');
        }
        return $this->null();

    }

}