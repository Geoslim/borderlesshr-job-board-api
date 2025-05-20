<?php

namespace App\Services;

use App\Exceptions\AuthException;
use App\Traits\HandlesAuthentication;
use Illuminate\Contracts\Auth\Authenticatable;

abstract class BaseAuthService
{
    use HandlesAuthentication;

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
        $this->revokeToken($user);
    }
}
