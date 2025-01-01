<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{
    use HasFactory;

    public const ROLE_ADMIN = 'Admin';
    public const ROLE_PENGURUS_LEMBAGA = 'Pengurus Lembaga';
    public const ROLE_PENGURUS_KEGIATAN = 'Pengurus Kegiatan';
    public const ROLE_MEMBER = 'Member';
}