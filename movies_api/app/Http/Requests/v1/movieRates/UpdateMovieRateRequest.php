<?php

namespace App\Http\Requests\v1\movieRates;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'rate' => ['required', 'integer', 'between:1,10']
        ];
    }
}
