<?php

namespace App\Services\Candidate;

use App\Models\Candidate;
use App\Services\BaseAuthService;

class AuthService extends BaseAuthService
{
    protected function getUserModelClass(): string
    {
        return Candidate::class;
    }
}
