<?php
namespace App\Etrack\Transformers\Company;

use App\Etrack\Entities\Company\CompanyFields;
use League\Fractal\TransformerAbstract;

class CompanyFieldTransformer extends TransformerAbstract
{

    public function transform(CompanyFields $model)
    {
        return [
            'name' => $model->name
        ];
    }

}