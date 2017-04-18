<?php
namespace App\Etrack\Transformers\Certification;

use App\Etrack\Entities\Certification\CertificationType;
use League\Fractal\TransformerAbstract;

class CertificationTypeTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'certifications',
    ];

    public function transform(CertificationType $model)
    {
        return [
            'id'         => $model->id,
            'name'       => $model->name,
            'created_at' => $model->created_at ? $model->created_at->format('d/m/Y') : null,
        ];
    }

    public function includeCertifications(CertificationType $model)
    {
        $certifications = $model->certifications;
        if ($certifications) {
            return $this->collection($certifications, new CertificationTransformer(), 'parent');
        }
    }
}