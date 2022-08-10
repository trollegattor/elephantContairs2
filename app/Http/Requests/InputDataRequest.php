<?php

namespace App\Http\Requests;

use App\Carriers\Exception\InputDataException;
use App\Rules\Uppercase;
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
    public function messages()
    {
        return [
            'origin.alpha'=>'The origin port must only contain letters',
            'origin.size'=>'The origin port must be 5 letters',
            'origin.App\Rules\Uppercase'=>'The origin port must be a title letters',
            'destination.alpha'=>'The destination port must only contain letters',
            'destination.size'=>'The destination port must be 5 letters',
            'destination.App\Rules\Uppercase'=>'The destination port must be a title letters',
            'amount.integer'=>'Amount of containers must be numeric',
            'amount.min'=>'Amount of containers  minimum 1',


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
        $data=$validator->errors()->all();
        $error=implode('; ',$data);
        throw new InputDataException($error,404);
    }


}
