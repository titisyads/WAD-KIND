<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
        'instagram',
        'kategori',
        'deskripsi',
        'logo',
        'pengurus_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pengurus_id');
    }
}
