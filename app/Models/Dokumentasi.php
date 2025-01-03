<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Dokumentasi extends Model
{
    use HasFactory;


    protected $fillable = [
        'id_kegiatan',
        'judul',
        'foto'
    ];


    public function kegiatan()
    {
        return $this->belongsTo(KegiatanVolunteer::class, 'id_kegiatan');
    }
}




