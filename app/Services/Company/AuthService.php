<?php

namespace App\Services\Company;

use App\Exceptions\AuthException;
use App\Models\Company;
use App\Traits\HandlesAuthentication;

class AuthService
{
    use HandlesAuthentication;

    /**
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        $company = Company::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] // hashed on the model
        ]);

        return $this->generateToken($company);
    }

    /**
     * @param array $data
     * @return array
     * @throws AuthException
     */
    public function login(array $data): array
    {
        $company = Company::whereEmail($data['email'])->first();

        $this->abortIfUnauthorized($company, $data);

        return $this->generateToken($company);
    }

    /**
     * @param Company $user
     * @return void
     */
    public function logout(Company $user): void
    {
        $this->revokeToken($user);
    }
}
