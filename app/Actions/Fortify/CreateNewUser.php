<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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
            'no_telepon' => ['required', 'numeric'],
            'jenis_kelamin' => ['required', 'in:Laki-Laki,Perempuan'],
            'alamat' => ['required', 'string'],
            'tanggal_lahir' => ['required', 'date'],
            'domisili' => ['required', 'string'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'no_telepon' => $input['no_telepon'],
            'jenis_kelamin' => $input['jenis_kelamin'],
            'alamat' => $input['alamat'],
            'tanggal_lahir' => $input['tanggal_lahir'],
            'domisili' => $input['domisili'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->syncRoles(Role::ROLE_MEMBER);
        return $user;
    }
}
