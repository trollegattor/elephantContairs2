<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class InputDataRequest extends FormRequest
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
                'origin' => ['required', 'string'],
                'destination' => ['required', 'string'],
                'amount' => ['required', 'integer', 'min:1'],
        ];
    }

    public function validationData(): array
    {
        return $this->route()->parameters();
    }


    protected function failedValidation(Validator $validator): void
    {
        throw new NotFoundHttpException();
    }
}
