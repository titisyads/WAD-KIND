<?php  


namespace App\Http\Controllers;  


use Illuminate\Http\Request;  
use App\Models\Volunteer; // Model Volunteer  
use App\Models\KegiatanVolunteer; // Model KegiatanVolunteer  
use App\Models\User;  
use App\Exports\VolunteerExport; // Ekspor Volunteer  
use Maatwebsite\Excel\Facades\Excel;  


class VolunteerController extends Controller  
{  
    /**  
     * Display a listing of the resource.  
     */  
    public function index()  
    {  
        if (auth()->user()->hasRole('Admin')) {  
            // Admin bisa melihat semua volunteer  
            $volunteers = Volunteer::all();  
            $title = 'Semua Volunteer';  
        } elseif (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga bisa melihat volunteer berdasarkan lembaga yang mereka kelola  
            $lembagas = auth()->user()->lembagas; // Ambil lembaga yang dimiliki user  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id');  


            // Ambil volunteers yang terhubung dengan kegiatan lembaga  
            $volunteers = Volunteer::whereIn('id_kegiatan', $kegiatanIds)->get();  
            $title = 'Semua Volunteer untuk Lembaga ' . ($lembagas->first()->nama);
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            // Pengurus Kegiatan hanya bisa melihat volunteer terkait kegiatan yang mereka kelola
            $kegiatans = auth()->user()->kegiatanVolunteers; // Ambil kegiatan yang dimiliki user
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id');  


            // Ambil volunteers yang terhubung dengan kegiatan mereka  
            $volunteers = Volunteer::whereIn('id_kegiatan', $kegiatanIds)->get();  
            $title = 'Volunteer untuk Kegiatan ' . ($kegiatans->first()->nama_kegiatan);  
        }


        return view('volunteers.index', compact('volunteers', 'title'));  
    }  


    /**  
     * Show the form for creating a new resource.  
     */  
    public function create()  
    {  
        // Ambil pengguna yang belum menjadi volunteer  
        $users = User::all();  
       
        if (auth()->user()->hasRole('Admin')) {  
            // Admin bisa memberikan akses ke semua kegiatan  
            $kegiatanVolunteers = KegiatanVolunteer::all();  
        } elseif (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga hanya melihat kegiatan yang relevan  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanVolunteers = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->get();  
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            // Pengurus Kegiatan hanya bisa melihat kegiatan mereka  
            $kegiatanVolunteers = KegiatanVolunteer::where('id_pengurus', auth()->id())->get();  
        } else {  
            return redirect()->route('home')->with('error', 'Anda tidak memiliki izin untuk membuat volunteer.');  
        }  


        return view('volunteers.create', compact('kegiatanVolunteers', 'users'));  
    }  


    /**  
     * Store a newly created resource in storage.  
     */  
    public function store(Request $request)  
    {  
        $validatedData = $request->validate([  
            'id_user' => 'required|exists:users,id',  
            'id_kegiatan' => 'required|exists:kegiatan_volunteers,id',  
            'status' => 'nullable|in:pending,approved,rejected',  
        ]);  


        // Set default status jika tidak disediakan  
        $validatedData['status'] = $validatedData['status'] ?? 'pending';  


        // Buat volunteer baru  
        Volunteer::create($validatedData);  


        return redirect()->route('volunteers.index')->with('success', 'Volunteer berhasil ditambahkan');  
    }  


    /**  
     * Display the specified resource.  
     */  
    public function show(string $id)  
    {  
        $volunteer = Volunteer::findOrFail($id);  
        return view('volunteers.show', compact('volunteer'));  
    }  


    /**  
     * Show the form for editing the specified resource.  
     */  
    public function edit(string $id)  
    {  
        $volunteer = Volunteer::findOrFail($id);  


        // Validasi akses edit berdasarkan peran  
        if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga hanya bisa mengedit volunteer yang terdaftar di kegiatan lembaga mereka  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id');  


            // Cek apakah kegiatan volunteer yang ingin diedit adalah kegiatan dari lembaga yang dimiliki user  
            if (!in_array($volunteer->id_kegiatan, $kegiatanIds->toArray())) {  
                return redirect()->route('volunteers.index')->with('error', 'Anda tidak memiliki izin untuk mengedit volunteer ini.');  
            }  
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            // Pengurus Kegiatan hanya bisa mengedit volunteer untuk kegiatan mereka  
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id');  


            // Cek apakah volunteer terdaftar di kegiatan yang mereka kelola  
            if (!in_array($volunteer->id_kegiatan, $kegiatanIds->toArray())) {  
                return redirect()->route('volunteers.index')->with('error', 'Anda tidak memiliki izin untuk mengedit volunteer ini.');  
            }  
        }  




        // Berikan hanya pilihan status  
        return view('volunteers.edit', compact('volunteer'));  
    }  


    /**  
     * Update the specified resource in storage.  
     */  
    public function update(Request $request, string $id)  
    {  
        $validatedData = $request->validate([  
            'status' => 'required|in:pending,approved,rejected', // Validasi status  
        ]);  


        $volunteer = Volunteer::findOrFail($id);  
       
        // Update hanya status volunteer  
        $volunteer->update($validatedData);  


        return redirect()->route('volunteers.index')->with('success', 'Status volunteer berhasil diperbarui');  
    }  


    /**  
     * Remove the specified resource from storage.  
     */  
    public function destroy(string $id)  
    {  
        // Temukan Volunteer berdasarkan ID  
        $volunteer = Volunteer::findOrFail($id);  


        // Hapus volunteer dari database  
        $volunteer->delete();  


        return redirect()->route('volunteers.index')->with('success', 'Volunteer berhasil dihapus');  
    }  


    /**  
     * Export data to Excel.  
     */  
    public function export()  
    {  
        // Menyiapkan query berdasarkan peran pengguna  
        if (auth()->user()->hasRole('Admin')) {  
            // Admin dapat mengekspor semua volunteer  
            $volunteers = Volunteer::with('user', 'kegiatan')->get(); // Ambil semua volunteer  
   
        } elseif (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga dapat mengekspor volunteer terkait lembaga yang mereka kelola  
            $lembagas = auth()->user()->lembagas; // Ambil lembaga yang dimiliki user  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id'); // Ambil ID kegiatan  
   
            $volunteers = Volunteer::whereIn('id_kegiatan', $kegiatanIds)->get(); // Ambil volunteer terkait kegiatan  
   
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            // Pengurus Kegiatan dapat mengekspor volunteer terkait kegiatan yang mereka kelola  
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id'); // Ambil ID kegiatan  
   
            $volunteers = Volunteer::whereIn('id_kegiatan', $kegiatanIds)->get(); // Ambil volunteer terkait kegiatan  
        }
   
        return Excel::download(new VolunteerExport($volunteers), 'volunteers.xlsx');  
    }
}
