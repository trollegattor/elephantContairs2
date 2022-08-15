<?php

namespace App\Http\Requests;

use App\Carriers\Exception\InputDataException;
use App\Rules\Uppercase;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class InputDataRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'origin' => ['alpha', 'size:5', new Uppercase()],
            'destination' => ['alpha', 'size:5', new Uppercase()],
            'amount' => ['integer', 'min:1'],
        ];
    }

    /**
     * @return array
     */
    public function validationData(): array
    {
        return $this->route()->parameters();
    }

    /**
     * @param Validator $validator
     * @return void
     * @throws InputDataException
     */
    protected function failedValidation(Validator $validator): void
    {
        $data = $validator->errors()->all();
        $error = implode('; ', $data);
        throw new InputDataException($error);
    }
}
