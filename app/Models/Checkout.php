<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  

class Checkout extends Model  
{  
    use HasFactory;  

    // Nama tabel, jika tabel tidak mengikuti konvensi penamaan Laravel   

    // Kolom yang dapat diisi massal  
    protected $fillable = [  
        'id_user',  
        'id_kegiatan',  
        'status',  
        'jumlah_bayar',  
        'metode_pembayaran',  
        'tanggal_checkout',  
    ];  

    // Definisikan relasi dengan tabel User  
    public function user()  
    {  
        return $this->belongsTo(User::class, 'id_user');  
    }  

    // Definisikan relasi dengan tabel Kegiatan  
    public function kegiatan()  
    {
        return $this->belongsTo(KegiatanVolunteer::class, 'id_kegiatan');
    }
}
