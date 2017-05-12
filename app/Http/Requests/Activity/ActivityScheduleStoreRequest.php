<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class ActivityScheduleStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'operator'                   => 'required',
            'schedule.programType'       => 'required',
            'schedule.periodicity'       => 'required',
            'schedule.initHour'          => 'required',
            'schedule.frequency'         => 'required',
            'schedule.estimatedTime'     => 'required',
            'schedule.estimatedTimeUnit' => 'required',
        ];
    }
}
