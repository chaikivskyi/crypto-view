<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class AlertHookRequest extends FormRequest
{
    private const MAX_PLOT_INDEX = 19;

    public function rules(): array
    {
        $rules = [];

        for ($i = 0; $i <= self::MAX_PLOT_INDEX; $i++) {
            $rules['plot_data.plot_' . $i] = ['sometimes', 'numeric', 'nullable'];
        }

        $rules = array_merge(
            $rules,
            [
                'plot_data' => ['required', 'array'],
                'ticker' => ['string', 'nullable'],
                'exchange' => ['string', 'nullable']
            ]
        );

        return $rules;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Invalid webhook request data',
            'errors' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST));
    }
}
