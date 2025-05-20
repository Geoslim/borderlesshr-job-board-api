<?php

namespace App\Traits;

use App\Exceptions\AuthException;
use App\Models\Candidate;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

trait HandlesAuthentication
{
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

    /**
     * @param Candidate|Company $user
     * @return void
     */
    public function revokeToken(Candidate|Company $user): void
    {
        $user->tokens()->each(function ($token) {
            $token->revoke();
        });
    }
}
