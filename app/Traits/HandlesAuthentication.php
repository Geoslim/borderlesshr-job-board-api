<?php

namespace App\Traits;

use App\Exceptions\AuthException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

trait HandlesAuthentication
{
    /**
     * @param Authenticatable|null $user
     * @param array $data
     * @return void
     * @throws AuthException
     */
    public function abortIfUnauthorized(Authenticatable|null $user, array $data): void
    {
        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new AuthException(
                'Authentication failed. Please verify your login information and try again.'
            );
        }
    }

    /**
     * @param Authenticatable $user
     * @return array
     */
    public function generateToken(Authenticatable $user): array
    {
        return [
            'token' => $user->createToken($user->email)->accessToken,
            'user' => $user
        ];
    }

    /**
     * @param Authenticatable $user
     * @return void
     */
    public function revokeToken(Authenticatable $user): void
    {
        $user->tokens()->each(function ($token) {
            $token->revoke();
        });
    }
}
