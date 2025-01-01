<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::FirstOrCreate([
            'name' => 'Admin',
            'no_telepon' => '08123456789',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Jl. Raya No. 1',
            'tanggal_lahir' => '2000-01-01',
            'domisili' => 'Jakarta',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),

        ]);

        $user->syncRoles(Role::ROLE_ADMIN);

        $user2 = User::FirstOrCreate([
            'name' => 'Dummy 1',
            'no_telepon' => '123456789',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Jl. Raya No. 1',
            'tanggal_lahir' => '2000-01-01',
            'domisili' => 'Jakarta',
            'email' => 'dummy1@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user2->save();

        $user3 = User::FirstOrCreate([
            'name' => 'Dummy 2',
            'no_telepon' => '123456789',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Jl. Raya No. 1',
            'tanggal_lahir' => '2000-01-01',
            'domisili' => 'Jakarta',
            'email' => 'dummy2@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user3->save();

        $user4 = User::FirstOrCreate([
            'name' => 'Dummy 3',
            'no_telepon' => '123456789',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Jl. Raya No. 1',
            'tanggal_lahir' => '2000-01-01',
            'domisili' => 'Jakarta',
            'email' => 'dummy3@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user4->save();

        $user5 = User::FirstOrCreate([
            'name' => 'Dummy 4',
            'no_telepon' => '123456789',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Jl. Raya No. 1',
            'tanggal_lahir' => '2000-01-01',
            'domisili' => 'Jakarta',
            'email' => 'dummy4@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user5->save();

        $user6 = User::FirstOrCreate([
            'name' => 'Dummy 5',
            'no_telepon' => '123456789',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Jl. Raya No. 1',
            'tanggal_lahir' => '2000-01-01',
            'domisili' => 'Jakarta',
            'email' => 'dummy5@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user6->save();

        $user7 = User::FirstOrCreate([
            'name' => 'Dummy 6',
            'no_telepon' => '123456789',
            'jenis_kelamin' => 'Laki-Laki',
            'alamat' => 'Jl. Raya No. 1',
            'tanggal_lahir' => '2000-01-01',
            'domisili' => 'Jakarta',
            'email' => 'dummy6@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $user7->save();
    }
}
