<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BaseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $message = '';
        foreach ($validator->errors()->toArray() as $item) {
            $message = $item[0];
            break;
        }

        $statusCodeError = Response::HTTP_FORBIDDEN;
        $json = [
            'code' => $statusCodeError,
            'message' => $message,
        ];
        $response = new JsonResponse($json, $statusCodeError);
        throw (new ValidationException($validator, $response))->status($statusCodeError);
    }
}
