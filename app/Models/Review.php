<?php
namespace App\Models;  


use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  


class Review extends Model  
{  
    use HasFactory;  


    // Mass assignable attributes  
    protected $fillable = [  
        'id_kegiatan',  
        'id_user',  
        'rating',  
        'komentar',  
        'tanggal',  
    ];  


    // Definisikan relasi ke model KegiatanVolunteer (id_kegiatan)  
    public function kegiatan()  
    {  
        return $this->belongsTo(KegiatanVolunteer::class, 'id_kegiatan');  
    }  


    // Definisikan relasi ke model User (id_user)  
    public function user()  
    {  
        return $this->belongsTo(User::class, 'id_user');  
    }  
}


