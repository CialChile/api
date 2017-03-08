<?php
namespace App\Etrack\Transformers\Adapters;

use App\Etrack\Transformers\Serializers\CustomSerializer;
use Dingo\Api\Transformer\Adapter\Fractal;
use League\Fractal\Manager;

class DingoCustomFractalAdapter extends Fractal
{

    public function __construct(Manager $fractal, $includeKey = 'include', $includeSeparator = ',', $eagerLoading = true)
    {
        $this->fractal = $fractal;
        $this->includeKey = $includeKey;
        $this->includeSeparator = $includeSeparator;
        $this->eagerLoading = $eagerLoading;
        $this->fractal->setSerializer(new CustomSerializer());
    }

}