<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class AlertHookRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'plot_one' => ['required', 'numeric'],
            'plot_two' => ['required', 'numeric'],
            'ticker' => ['string', 'nullable'],
            'exchange' => ['string', 'nullable'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Invalid request data',
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST));
    }
}
