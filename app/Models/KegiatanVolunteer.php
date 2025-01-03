<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class KegiatanVolunteer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_lembaga',
        'nama_kegiatan',
        'deskripsi',
        'tanggal',
        'lokasi',
        'kategori',
        'kuota',
        'jenis',
        'harga',
        'banner',
        'id_pengurus'
    ];


    public function lembaga()  
    {  
        return $this->belongsTo(Lembaga::class, 'id_lembaga');  
    }  


    public function user()  
    {  
        return $this->belongsTo(User::class, 'id_pengurus');  
    }  
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_kegiatan');
    }
}
