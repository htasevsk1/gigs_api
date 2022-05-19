<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGigRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'company_id' => 'required|exists:companies,id',
            'description' => 'required|string',
            'start_time' => 'required|date_format:"Y-m-d H:i:s"|before:end_time',
            'end_time' => 'required|date_format:"Y-m-d H:i:s"',
            'number_of_positions' => 'required|between:0,65535',
            'pay_per_hour' => 'required|numeric|min:0',
            'status' => 'required|boolean'
        ];
    }
}
