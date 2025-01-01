<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Volunteer extends Model
{
    use HasFactory;


    protected $fillable = [  
        'id_user',  
        'id_kegiatan',  
        'status'
    ];  


    // Relasi ke model User  
    public function user()  
    {  
        return $this->belongsTo(User::class, 'id_user');  
    }  


    // Relasi ke model KegiatanVolunteer  
    public function kegiatan()  
    {  
        return $this->belongsTo(KegiatanVolunteer::class, 'id_kegiatan');  
    }  
}




