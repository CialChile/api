<?php
namespace App\Etrack\Transformers\Institute;

use App\Etrack\Entities\Institute\Institute;
use App\Etrack\Transformers\Certification\CertificationTransformer;
use League\Fractal\TransformerAbstract;

class InstituteTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'certifications',
    ];

    public function transform(Institute $model)
    {
        return [
            'id'                => $model->id,
            'name'              => $model->name,
            'rut'               => $model->rut,
            'address'           => $model->address,
            'country'           => $model->country,
            'state'             => $model->state,
            'city'              => $model->city,
            'contact'           => $model->contact,
            'telephone_contact' => $model->telephone_contact,
            'email_contact'     => $model->email_contact,
            'created_at'        => $model->created_at ? $model->created_at->format('d/m/Y') : null,
        ];
    }

    public function includeCertifications(Institute $model)
    {
        $certifications = $model->certifications;
        if ($certifications) {
            return $this->collection($certifications, new CertificationTransformer(), 'parent');
        }
    }
}