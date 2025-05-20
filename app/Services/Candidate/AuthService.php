<?php

namespace App\Services\Candidate;

use App\Exceptions\AuthException;
use App\Models\Candidate;
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
        $candidate = Candidate::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] // hashed on the model
        ]);

        return $this->generateToken($candidate);
    }

    /**
     * @param array $data
     * @return array
     * @throws AuthException
     */
    public function login(array $data): array
    {
        $candidate = Candidate::whereEmail($data['email'])->first();

        $this->abortIfUnauthorized($candidate, $data);

        return $this->generateToken($candidate);
    }

    /**
     * @param Candidate $user
     * @return void
     */
    public function logout(Candidate $user): void
    {
        $this->revokeToken($user);
    }
}
