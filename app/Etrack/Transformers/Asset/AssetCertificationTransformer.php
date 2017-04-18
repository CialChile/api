<?php
namespace App\Etrack\Transformers\Asset;

use App\Etrack\Entities\Certification\Certification;
use App\Etrack\Entities\Certification\CertificationWorkerAsset;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AssetCertificationTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'documents'
    ];

    public function transform(Certification $model)
    {
        return [
            'certification_id' => $model->id,
            'name'             => $model->name,
            'start_date'       => Carbon::parse($model->pivot->start_date)->format('d/m/Y'),
            'end_date'         => Carbon::parse($model->pivot->end_date)->format('d/m/Y')
        ];
    }

    public function includeDocuments(Certification $model)
    {
        $certificationWorkerAsset = CertificationWorkerAsset::find($model->pivot->id);
        if ($certificationWorkerAsset) {
            $documents = $certificationWorkerAsset->getMedia('documents');
            if ($documents->isEmpty()) {
                return $this->null();
            }
            return $this->collection($documents, new AssetDocumentsTransformer(), 'parent');
        }

        return $this->null();
    }
}