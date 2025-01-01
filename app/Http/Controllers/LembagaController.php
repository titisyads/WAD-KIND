<?php  

namespace App\Http\Controllers;  

use App\Models\Lembaga;  
use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Storage; // Untuk menyimpan file ke storage  
use App\Models\User;
use App\Models\Role;
use Maatwebsite\Excel\Facades\Excel;   
use App\Exports\LembagaExport; // Import kelas export  

class LembagaController extends Controller  
{  
    /**  
     * Display a listing of the resource.  
     */  
    public function index()  
    {  
        if (auth()->user()->hasRole('Admin')) {  
            $lembagas = Lembaga::all();
            // Pastikan ada relasi di model User  
        } else if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            $lembagas = auth()->user()->lembagas;   
        }  
        
        return view('lembagas.index', compact('lembagas'));  
    }  
    /**  
     * Show the form for creating a new resource.  
     */  
    public function create()  
    {  
        if (auth()->user()->hasRole('Admin')) {  
            $user = User::where('id', '!=', auth()->id())->whereDoesntHave('roles', function($query) {
                $query->whereIn('name', ['Admin', 'Pengurus Lembaga', 'Pengurus Kegiatan']);
            })->get();
            return view('lembagas.create', compact('user'));  
        }else if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            return redirect()->route('lembagas.index')->with('error', 'Anda tidak memiliki izin untuk membuat lembaga');  
        }
        return view('lembagas.create', compact('user'));  
    }  

    /**  
     * Store a newly created resource in storage.  
     */  
    public function store(Request $request)  
    {  
        $validatedData = $request->validate([  
            'nama' => 'required|string|max:255',  
            'alamat' => 'required|string|max:255',  
            'telepon' => 'required|string|max:15',
            'email' => 'required|email|max:255',  
            'instagram' => 'nullable|string|max:255',  
            'kategori' => 'required|in:education,health,environment,social service,community service,animal', 
            'deskripsi' => 'nullable|string',  
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'pengurus_id' => 'required|unique:lembagas,pengurus_id|exists:users,id', 
        ]);  

        // Proses menyimpan logo  
        $imageExtension = $request->logo->extension(); 
        $imageName =  $validatedData['nama'] . '.' . $imageExtension; 
        $request->logo->move(public_path('images'), $imageName);  

        // Membuat lembaga baru  
        Lembaga::create([  
            'nama' => $validatedData['nama'],  
            'alamat' => $validatedData['alamat'],  
            'telepon' => $validatedData['telepon'],  
            'email' => $validatedData['email'],  
            'instagram' => $validatedData['instagram'],  
            'kategori' => $validatedData['kategori'],  
            'deskripsi' => $validatedData['deskripsi'],  
            'logo' => 'images/' . $imageName, 
            'pengurus_id' => $validatedData['pengurus_id'], 
        ]); 
        
        $user = User::findOrFail($validatedData['pengurus_id']);
        $user->syncRoles(Role::ROLE_PENGURUS_LEMBAGA);

        return redirect()->route('lembagas.index')->with('success', 'Lembaga berhasil ditambahkan');  
    }  

    /**  
     * Display the specified resource.  
     */  
    public function show(string $id)  
    {  
        $lembaga = Lembaga::findOrFail($id);  
        
        // Periksa apakah pengguna yang sedang login adalah pengurus lembaga yang sama  
        if (auth()->user()->hasRole('Pengurus Lembaga') && $lembaga->pengurus_id !== auth()->id()) {  
            return redirect()->route('lembagas.index')->with('error', 'Anda tidak memiliki izin untuk melihat lembaga ini.');  
        }  
        
        return view('lembagas.show', compact('lembaga'));  
    } 

    /**  
     * Show the form for editing the specified resource.  
     */  
    public function edit(string $id)  
    {  
        $lembaga = Lembaga::findOrFail($id);  
    
        // Periksa apakah pengguna yang sedang login adalah pengurus lembaga yang sama  
        if (auth()->user()->hasRole('Pengurus Lembaga') && $lembaga->pengurus_id !== auth()->id()) {  
            return redirect()->route('lembagas.index')->with('error', 'Anda tidak memiliki izin untuk mengedit lembaga ini.');  
        }  
        
        if (auth()->user()->hasRole('Admin')) {  
            $user = User::where('id', '!=', auth()->id())->whereDoesntHave('roles', function($query) {  
                $query->whereIn('name', ['Admin', 'Pengurus Kegiatan']);  
            })->get();  
        } else if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            $user = User::where('id', $lembaga->pengurus_id)->get();
        } 
        
        return view('lembagas.edit', compact('lembaga', 'user'));  
    }  

    /**  
     * Update the specified resource in storage.  
     */  
    public function update(Request $request, string $id)  
{  
    $validatedData = $request->validate([  
        'nama' => 'required|string|max:255',  
        'alamat' => 'required|string|max:255',  
        'telepon' => 'required|string|max:15',  
        'email' => 'required|email|max:255',  
        'instagram' => 'nullable|string|max:255',  
        'kategori' => 'required|string|max:50',  
        'deskripsi' => 'nullable|string',  
        'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',   
        'pengurus_id' => 'nullable|exists:users,id', 
    ]);  

    $lembaga = Lembaga::findOrFail($id); 
    // Cek apakah pengurus_id sudah terdaftar di lembaga lain (kecuali lembaga saat ini)  
    if (Lembaga::where('pengurus_id', $validatedData['pengurus_id'])  
                ->where('id', '!=', $lembaga->id)  
                ->exists()) {  
        return redirect()->back()->withErrors(['pengurus_id' => 'Pengurus ini sudah terdaftar di lembaga lain.']);  
    }  

    // Temukan lembaga berdasarkan ID  
    $lembaga = Lembaga::findOrFail($id);  

    // Cek apakah ada logo baru yang diunggah  
    if ($request->hasFile('logo')) {  
        // Hapus logo lama jika ada  
        if ($lembaga->logo) {  
            $oldLogoPath = public_path($lembaga->logo);  
            if (file_exists($oldLogoPath)) {  
                unlink($oldLogoPath); 
            }  
        }  

        // Ambil ekstensi file logo baru  
        $imageExtension = $request->logo->extension();  
        $imageName =  $validatedData['nama'] . '.' . $imageExtension;  
        $request->logo->move(public_path('images'), $imageName);  

        // Update data lembaga dengan logo baru  
        $validatedData['logo'] = 'images/' . $imageName; // Simpan path logo baru  
    } else {  
        
        $validatedData['logo'] = $lembaga->logo;  
    }  

    // Cek apakah pengurus_id berubah
    if ($validatedData['pengurus_id'] !== null && $lembaga->pengurus_id != $validatedData['pengurus_id']) { 
        // Hapus role dari pengurus sebelumnya
        $oldPengurus = User::findOrFail($lembaga->pengurus_id);
        $oldPengurus->syncRoles([]);

        // Tambahkan role untuk pengurus yang baru
        $newPengurus = User::findOrFail($validatedData['pengurus_id']);
        $newPengurus->syncRoles(Role::ROLE_PENGURUS_LEMBAGA);
    }

    $lembaga->update($validatedData);  

    return redirect()->route('lembagas.index')->with('success', 'Lembaga berhasil diupdate');  
}


    public function destroy(string $id)  
    {  
        $lembaga = Lembaga::findOrFail($id);  

        if ($lembaga->logo) {  
            $logoPath = public_path($lembaga->logo);  
            if (file_exists($logoPath)) {  
                unlink($logoPath); 
            }  
        }
        $lembaga->user->roles()->detach(); 

        $lembaga->delete();  

        return redirect()->route('lembagas.index')->with('success', 'Lembaga berhasil dihapus');  
    }  

    public function export(Request $request)  
    {  
        if (auth()->user()->hasRole('Admin')) {  
            $lembaga = Lembaga::all();  
        } else if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            $lembaga = auth()->user()->lembagas;  
        } 
        return Excel::download(new LembagaExport($lembaga), 'lembagas.xlsx');  
    }  
}