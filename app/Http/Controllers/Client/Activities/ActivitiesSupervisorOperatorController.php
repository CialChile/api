<?php
namespace App\Http\Controllers\Client\Activities;

use App\Etrack\Entities\Auth\User;
use App\Etrack\Entities\Template\Template;
use App\Etrack\Transformers\Auth\UserTransformer;
use App\Http\Controllers\Controller;
use Dingo\Api\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ActivitiesSupervisorOperatorController extends Controller
{
    public function __construct()
    {
        $this->module = 'client-activities-activities';
    }

    public function search(Request $request, $subject)
    {
        if ($subject != 'operator' && $subject != 'supervisor') {
            return $this->response->errorBadRequest('Verificar el tipo de usuario, debe ser operator o supervisor');
        }
        $name = $request->get('name');
        $templateId = $request->get('template');
        $company_id = \Auth::user()->company_id;

        $template = Template::where(function (Builder $q) use ($company_id) {
            return $q->where('company_id', $company_id)->orWhere('is_custom', false);
        })->find($templateId);

        if (!$template) {
            return $this->response->collection(collect(), new UserTransformer());
        }

        /** @var User $query */
        $query = User::inCompany();

        if ($name) {
            $query = $query->whereRaw("(CONCAT(users.first_name,' ',users.last_name) like ?)", [$name . '%']);
        }
        $validations = [
            'roles'          => '',
            'certifications' => '',
            'specialties'    => '',
            'positions'      => '',
            'experience'     => null
        ];
        $templateValidations = collect($template->template['persons'][$subject]);
        $templateValidations->each(function ($validation) use (&$validations) {
            switch ($validation['value']['name']) {
                case 'role':
                    $validations['roles'] .= $validation['validation']['slug'] . ',';
                    break;
                case 'certifications':
                    $validations['certifications'] .= $validation['validation']['id'] . ',';
                    break;
                case 'position':
                    $validations['positions'] .= $validation['validation']['name'] . ',';
                    break;
                case 'specialty':
                    $validations['specialties'] .= $validation['validation']['name'] . ',';
                    break;
                case 'experience':
                    $validations['experience'] = $validation['validation'];
                    break;
            }
        });

        if ($validations['roles']) {
            $validations['roles'] = substr($validations['roles'], 0, strlen($validations['roles']) - 1);
            $query = $query->hasQueryRoles($validations['roles']);
        }

        if ($validations['certifications']) {
            $validations['certifications'] = substr($validations['certifications'], 0, strlen($validations['certifications']) - 1);
            $query = $query->hasCertifications($validations['certifications']);
        }

        if ($validations['positions']) {
            $validations['positions'] = substr($validations['positions'], 0, strlen($validations['positions']) - 1);
            $query = $query->hasPositions($validations['positions']);
        }

        if ($validations['specialties']) {
            $validations['specialties'] = substr($validations['specialties'], 0, strlen($validations['specialties']) - 1);
            $query = $query->hasSpecialties($validations['specialties']);
        }
        $users = $query->get();
        return $this->response->collection($users, new UserTransformer());
    }
}