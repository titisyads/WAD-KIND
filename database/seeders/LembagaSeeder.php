<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lembaga;
use App\Models\Role;

class LembagaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $pengurusId = 2;
        $pengurus = User::find($pengurusId);


        // Sinkronisasi role ROLE_PENGURUS_LEMBAGA
        $pengurus->syncRoles(Role::ROLE_PENGURUS_LEMBAGA);
        Lembaga::FirstOrCreate([
            'nama' => 'Peduli Indonesia',
            'alamat' => 'Jl. Tebet No.123, Jakarta',
            'telepon' => '081234567890',
            'email' => 'peduli@lembaga.com',
            'instagram' => 'peduli_official',
            'kategori' => 'social service',
            'deskripsi' => 'Lembaga yang bergerak di bidang pelayanan masyarakat untuk meningkatkan kesejahteraan.',
            'logo' => 'images/peduliindonesia.png', // Pastikan file ini ada di folder public
            'pengurus_id' => $pengurusId,
        ]);
    }
}
