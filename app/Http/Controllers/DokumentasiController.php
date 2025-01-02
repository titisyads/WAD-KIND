<?php  


namespace App\Http\Controllers;  


use Illuminate\Http\Request;  
use App\Models\Dokumentasi; // Model Dokumentasi  
use App\Models\KegiatanVolunteer; // Model KegiatanVolunteer  
use Maatwebsite\Excel\Facades\Excel;  
use App\Exports\DokumentasiExport; // Ekspor Dokumentasi  


class DokumentasiController extends Controller  
{  
    /**  
     * Display a listing of the resource.  
     */  
    public function index()  
    {  
        if (auth()->user()->hasRole('Admin')) {  
            // Admin bisa melihat semua dokumentasi  
            $dokumentasi = Dokumentasi::with('kegiatan')->get();  
            $title = 'Semua Dokumentasi';  
        } elseif (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga bisa melihat dokumentasi berdasarkan lembaga yang mereka kelola  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id');  


            // Ambil dokumentasi yang terhubung dengan kegiatan lembaga  
            $dokumentasi = Dokumentasi::whereIn('id_kegiatan', $kegiatanIds)->with('kegiatan')->get();  
            $title = 'Dokumentasi untuk Lembaga ' . ($lembagas->first()?->nama);    
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            $kegiatans = auth()->user()->kegiatanVolunteers;
            // Pengurus Kegiatan hanya bisa melihat dokumentasi terkait kegiatan yang mereka kelola  
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id');  


            // Ambil dokumentasi yang terhubung dengan kegiatan mereka  
            $dokumentasi = Dokumentasi::whereIn('id_kegiatan', $kegiatanIds)->with('kegiatan')->get();  
            $title = 'Dokumentasi untuk Kegiatan ' . ($kegiatans->first()->nama_kegiatan);
        }  


        return view('dokumentasis.index', compact('dokumentasi', 'title'));  
    }  


/**  
 * Show the form for creating a new resource.  
 */  
public function create()  
{  
    // Ambil pengguna yang sedang melakukan request  
    $user = auth()->user();  


    if ($user->hasRole('Admin')) {  
        // Admin bisa memberikan akses ke semua kegiatan  
        $kegiatanVolunteers = KegiatanVolunteer::all();  
    } elseif ($user->hasRole('Pengurus Lembaga')) {  
        // Pengurus Lembaga hanya melihat kegiatan yang relevan  
        $lembagas = $user->lembagas;  
        $kegiatanVolunteers = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->get();  
    } elseif ($user->hasRole('Pengurus Kegiatan')) {  
        // Pengurus Kegiatan hanya bisa melihat kegiatan mereka sendiri  
        $kegiatanVolunteers = KegiatanVolunteer::where('id_pengurus', $user->id)->get();  
    }
    return view('dokumentasis.create', compact('kegiatanVolunteers'));  
}


    /**  
     * Store a newly created resource in storage.  
     */  
    public function store(Request $request)  
    {  
        $validatedData = $request->validate([  
            'id_kegiatan' => 'required|exists:kegiatan_volunteers,id',  
            'judul' => 'required|string|max:255',  
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
        ]);  


        // Proses menyimpan logo
        $kegiatanName = KegiatanVolunteer::findOrFail($validatedData['id_kegiatan'])->nama_kegiatan;
        $imageExtension = $request->foto->extension(); // Ambil ekstensi file  
        $imageName = $kegiatanName . '_ Foto' . '_' . $validatedData['judul'] . '.' . $imageExtension; // Ganti nama file dengan nama lembaga  
        $request->foto->move(public_path('images'), $imageName);  


        // Buat dokumentasi baru  
        Dokumentasi::create([  
            'id_kegiatan' => $validatedData['id_kegiatan'],  
            'judul' => $validatedData['judul'],  
            'foto' => 'images/' . $imageName, // Menyimpan path foto
        ]);


        return redirect()->route('dokumentasis.index')->with('success', 'Dokumentasi berhasil ditambahkan');  
    }  


    /**  
     * Display the specified resource.  
     */  
    public function show(string $id)  
    {  
        $dokumentasi = Dokumentasi::with('kegiatan')->findOrFail($id);  
        return view('dokumentasis.show', compact('dokumentasi'));  
    }  


    /**  
     * Show the form for editing the specified resource.  
     */  
    public function edit(string $id)  
    {  
        $dokumentasi = Dokumentasi::findOrFail($id);  
        $kegiatanVolunteers = KegiatanVolunteer::all(); // Menampilkan semua kegiatan untuk dropdown  


        return view('dokumentasis.edit', compact('dokumentasi', 'kegiatanVolunteers'));  
    }  


    /**  
     * Update the specified resource in storage.  
     */  
    public function update(Request $request, string $id)  
    {  
        $validatedData = $request->validate([  
            'id_kegiatan' => 'required|exists:kegiatan_volunteers,id',  
            'judul' => 'required|string|max:255',  
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
        ]);  


        $dokumentasi = Dokumentasi::findOrFail($id);  
       
        // Cek apakah ada logo baru yang diunggah  
        if ($request->hasFile('foto')) {  
            // Hapus foto lama jika ada  
            if ($dokumentasi->foto) {  
                $oldFotoPath = public_path($dokumentasi->foto);  
                if (file_exists($oldFotoPath)) {  
                    unlink($oldFotoPath); // Hapus file foto lama  
                }  
            }  


            // Ambil ekstensi file foto baru  
            $imageExtension = $request->foto->extension();  
            $imageName =  $validatedData['nama'] . '.' . $imageExtension;  
            $request->foto->move(public_path('images'), $imageName);  


            // Update data dokumentasi dengan foto baru  
            $validatedData['foto'] = 'images/' . $imageName; // Simpan path foto baru  
        } else {  
            // Jika tidak ada foto baru, tetap gunakan foto lama  
            $validatedData['foto'] = $dokumentasi->foto;  
        }  




        // Update dokumentasi  
        $dokumentasi->update($validatedData);  


        return redirect()->route('dokumentasis.index')->with('success', 'Dokumentasi berhasil diperbarui');  
    }  


    /**  
     * Remove the specified resource from storage.  
     */  
    public function destroy(string $id)  
    {  
        $dokumentasi = Dokumentasi::findOrFail($id);  


        // Menghapus foto dari penyimpanan  
        // Hapus file logo jika ada  
        if ($dokumentasi->foto) {  
            $fotoPath = public_path($dokumentasi->foto);  
            if (file_exists($fotoPath)) {  
                unlink($fotoPath); // Hapus file foto dari sistem file  
            }  
        }


        // Hapus dokumentasi dari database  
        $dokumentasi->delete();  


        return redirect()->route('dokumentasis.index')->with('success', 'Dokumentasi berhasil dihapus');  
    }  


    /**  
     * Export data to Excel.  
     */  
    public function export()  
    {  
        // Mengambil semua dokumentasi untuk di ekspor jika pengguna admin  
        if (auth()->user()->hasRole('Admin')) {  
            $dokumentasi = Dokumentasi::with('kegiatan')->get();  
        } elseif (auth()->user()->hasRole('Pengurus Lembaga')) {  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id');  
            $dokumentasi = Dokumentasi::whereIn('id_kegiatan', $kegiatanIds)->get();  
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id');  
            $dokumentasi = Dokumentasi::whereIn('id_kegiatan', $kegiatanIds)->get();  
        }  


        return Excel::download(new DokumentasiExport($dokumentasi), 'dokumentasis.xlsx');  
    }  
}




