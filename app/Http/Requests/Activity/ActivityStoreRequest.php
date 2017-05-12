<?php

namespace App\Http\Requests\Activity;

use App\Etrack\Entities\Template\Template;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;

class ActivityStoreRequest extends FormRequest
{
    private $template;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->template) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $templateId = $this->request->get('template_id');
        $company_id = \Auth::user()->company_id;
        $this->template = Template::where(function (Builder $q) use ($company_id) {
            return $q->where('company_id', $company_id)->orWhere('is_custom', false);
        })->find($templateId);

        if (!$this->template) {
            return [];
        }
        $descriptionRequired = $this->template->template['general'][1]['required'];
        $hasSupervisor = array_key_exists('persons', $this->template->template) ? $this->template->template['persons']['hasSupervisor'] : false;
        $rules = [
            'name'            => 'required',
            'program_type_id' => 'required',
            'template_id'     => 'required'
        ];

        if ($descriptionRequired) {
            $rules['description'] = 'required';
        }

        if ($hasSupervisor) {
            $rules['supervisor'] = 'required';
        }

        return $rules;
    }
}
