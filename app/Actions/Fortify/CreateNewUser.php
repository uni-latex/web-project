<?php

namespace App\Actions\Fortify;

use App\Models\Invite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        $invite = Invite::where('token', $input['token'])
            ->where('email', $input['email'])
            ->whereNull('used_at')
            ->whereDate('expired_at', '>', now())
            ->first();

        if (! $invite) {
            throw ValidationException::withMessages(['email' => 'Invalid token or email']);
        }

        $invite->update([
            'used_at' => now()
        ]);

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if ($invite->role) {
            $user->assignRole($invite->role);
        }

        return $user;
    }
}
