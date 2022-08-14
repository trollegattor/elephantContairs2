<?php

namespace App\Http\Requests;

use App\Carriers\Exception\InputDataException;
use App\Rules\Uppercase;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            'origin' => ['alpha','size:5',new Uppercase()],
            'destination' => ['alpha','size:5',new Uppercase()],
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


    protected function failedValidation(Validator $validator)
    {
        $data=$validator->errors()->all();
        $error=implode('; ',$data);
        throw new InputDataException($error);
    }
}
