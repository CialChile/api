<?php
namespace App\Etrack\Services\Client\Certification;

use App\Etrack\Entities\Certification\Certification;
use Dingo\Api\Routing\Helpers;

class CertificationValidationService
{
    use Helpers;

    public function validateCertificationTypeChange(Certification $certification, $type)
    {
        if ($type != $certification->type) {
            if ($type != 2) {
                if ($type == 1 && $certification->workers->count()) {
                    $this->response->errorForbidden('Esta cerfificación no puede cambiar a quien aplica, pues ya tiene trabajadores asociados a ella.');
                }
                if ($type == 0 && $certification->assets->count()) {
                    $this->response->errorForbidden('Esta cerfificación no puede cambiar a quien aplica, pues ya tiene activos asociados a ella.');
                }
            }
        }
    }
}