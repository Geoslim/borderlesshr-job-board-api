<?php

namespace App\Services;

use App\Exceptions\AuthException;
use App\Models\Candidate;
use App\Models\Company;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

abstract class BaseAuthService
{
    abstract protected function getUserModelClass(): string;

    /**
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        $modelClass = $this->getUserModelClass();

        $user = $modelClass::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'] // hashed on the model
        ]);

        return $this->generateToken($user);
    }

    /**
     * @param array $data
     * @return array
     * @throws AuthException
     */
    public function login(array $data): array
    {
        $modelClass = $this->getUserModelClass();

        $user = $modelClass::whereEmail($data['email'])->first();

        $this->abortIfUnauthorized($user, $data);

        return $this->generateToken($user);
    }

    /**
     * @param Authenticatable $user
     * @return void
     */
    public function logout(Authenticatable $user): void
    {
        $user->tokens()->each(function ($token) {
            $token->revoke();
        });
    }

    /**
     * @param Candidate|Company|null $user
     * @param array $data
     * @return void
     * @throws AuthException
     */
    public function abortIfUnauthorized(Candidate|Company|null $user, array $data): void
    {
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new AuthException(
                'Authentication failed. Please verify your login information and try again.'
            );
        }
    }

    /**
     * @param Candidate|Company $user
     * @return array
     */
    public function generateToken(Candidate|Company $user): array
    {
        return [
            'token' => $user->createToken($user->email)->accessToken,
            'user' => $user
        ];
    }
}
