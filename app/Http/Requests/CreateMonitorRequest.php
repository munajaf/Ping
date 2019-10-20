<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateMonitorRequest extends FormRequest
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
            'url' => [
                'required',
                'url',
                Rule::unique('monitors')->where('user_id', auth()->user()->id),
            ],
        ];
    }

    public function getValidatorInstance()
    {
        $this->request->replace(['url' => trim($this->request->get('url'), '/')]);
        return parent::getValidatorInstance();
    }

}
