<?php  

namespace App\Http\Controllers;  

use Illuminate\Http\Request;  
use Midtrans\Config;  
use Midtrans\Snap;  
use App\Models\Checkout;   
use App\Models\KegiatanVolunteer; // Gunakan model yang sesuai  
use App\Models\Volunteer; // Tambahkan model Volunteer  
use Midtrans\Notification;  
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller  
{  
    public function index()  
    {  
        // Logika untuk menampilkan semua checkout  
    }  

    public function showCheckoutForm(KegiatanVolunteer $kegiatan)  
    {  
        return view('checkout', compact('kegiatan'));  
    }  
    
    public function processCheckout(Request $request)  
    {  
        // Validasi data yang diperlukan  
        $validatedData = $request->validate([  
            'kegiatan_id' => 'required|exists:kegiatan_volunteers,id', // Ganti cek ke tabel kegiatan_volunteers  
        ]);  

        // Ambil data kegiatan  
        $kegiatan = KegiatanVolunteer::find($validatedData['kegiatan_id']);  
        
        // Validasi kegiatan berbayar  
        if ($kegiatan->jenis !== 'berbayar') {   
            return redirect()->back()->with('error', 'Kegiatan ini tidak dapat di-checkout.');   
        }  

        // Validasi kuota  
        if ($kegiatan->kuota <= 0) {  
            return redirect()->back()->with('error', 'Kuota kegiatan tidak tersedia.');  
        }  
        
        $totalHarga = $kegiatan->harga; // Total harga untuk satu pengguna  

        // Simpan data checkout ke database  
        $checkout = Checkout::create([  
            'id' => uniqid(), 
            'id_user' => auth()->id(),  
            'id_kegiatan' => $kegiatan->id,  
            'jumlah_bayar' => $totalHarga,  
            'metode_pembayaran' => $request->input('metode_pembayaran'), // Ambil metode pembayaran jika ada  
            'tanggal_checkout' => now(),  
            'status' => 'pending',  
        ]);  

        // Konfigurasi Midtrans  
        Config::$serverKey = config('midtrans.server_key');  
        Config::$isProduction = config('midtrans.is_production');  
        Config::$isSanitized = config('midtrans.is_sanitized');  
        Config::$is3ds = config('midtrans.is_3ds');  

        // Buat transaksi  
        $transactionDetails = [  
            'order_id' => $checkout->id,  
            'gross_amount' => $totalHarga,  
        ];  

        $itemDetails = [  
            [  
                'id' => $kegiatan->id,  
                'price' => $kegiatan->harga,  
                'quantity' => 1, // Selalu 1 karena hanya ada satu pengguna yang checkout  
                'name' => $kegiatan->nama_kegiatan,  
            ],  
        ];  

        $transactionData = [  
            'transaction_details' => $transactionDetails,  
            'item_details' => $itemDetails,  
            'customer_details' => [  
                'first_name' => auth()->user()->name,  
                'email' => auth()->user()->email,  
            ],  
        ];  

        // Dapatkan URL pembayaran dari Midtrans  
        $snapToken = Snap::getSnapToken($transactionData);  

        return view('checkout_payment', compact('snapToken'));  
    }  

    public function handleNotification(Request $request)  
    {  
        // Ambil data notifikasi dari Midtrans  
        $payload = $request->getContent();  
        $notification = json_decode($payload);
        Log::info('Midtrans Notification:', (array) $notification);
        $transaction_status = $notification->transaction_status;  
        $payment_type = $notification->payment_type;  
        $orderId = $notification->order_id;  
        $fraud = $notification->fraud_status;  

        $checkout = Checkout::where('id', $orderId)->first();  

        // Cek status transaksi  
        if ($transaction_status == 'capture') {  
            if ($payment_type == 'credit_card') {  
                if ($fraud == 'challenge') {  
                    $checkout->update(['status' => 'pending']);  
                } else {  
                    $checkout->update(['status' => 'success']);  
                }  
            }  
        } elseif ($transaction_status == 'settlement') {  
            $checkout->update(['status' => 'success']);  
        } elseif ($transaction_status == 'pending') {  
            $checkout->update(['status' => 'pending']);  
        } elseif ($transaction_status == 'deny') {  
            $checkout->update(['status' => 'failed']);  
        } elseif ($transaction_status == 'expire') {  
            $checkout->update(['status' => 'expired']);  
        } elseif ($transaction_status == 'cancel') {  
            $checkout->update(['status' => 'canceled']);  
        }  
        
        // Setelah status berhasil diupdate, kurangi kuota kegiatan dan tambahkan volunteer
        if ($checkout->status == 'success') {  
            $kegiatan = KegiatanVolunteer::find($checkout->id_kegiatan);  
            $kegiatan->kuota -= 1; // Mengurangi kuota untuk satu peserta  
            if ($kegiatan->kuota < 0) {  
                $kegiatan->kuota = 0; // Pastikan kuota tidak negatif  
            }  
            $kegiatan->save(); // Simpan perubahan  
            $this->addVolunteer($checkout); // Masukkan pengguna ke tabel volunteers  
        }  
    }  

    private function addVolunteer($checkout)   
    {  
        // Menambahkan user ke tabel volunteers dengan status approved  
        Volunteer::create([  
            'id_user' => $checkout->id_user,  
            'id_kegiatan' => $checkout->id_kegiatan,  
            'status' => 'approved',  
        ]);  
    }  
}