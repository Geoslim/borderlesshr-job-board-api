<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

trait HandlesFailedValidation
{
    use HandlesJsonResponses;

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     * @return void
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        $error = $validator->errors()->first();
        Log::error('validation message', [$error]);
        throw new HttpResponseException($this->error($error));
    }
}
