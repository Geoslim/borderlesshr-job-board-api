<?php

namespace App\Services\Company;

use App\Models\Company;
use App\Services\BaseAuthService;

class AuthService extends BaseAuthService
{
    protected function getUserModelClass(): string
    {
        return Company::class;
    }
}
