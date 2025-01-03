<?php
namespace App\Http\Controllers;  


use Illuminate\Http\Request;  
use App\Models\KegiatanVolunteer;  
use App\Models\Lembaga; 
use App\Models\User;
use App\Models\Role;
use App\Models\Volunteer;
use App\Exports\KegiatanVolunteerExport; 
use Maatwebsite\Excel\Facades\Excel;  


class KegiatanVolunteerController extends Controller  
{  
    /**  
     * Display a listing of the resource.  
     */  
    public function index()
    {
        // Default values
        $kegiatanVolunteers = collect(); // Empty collection as default
        $title = 'Kegiatan Volunteer'; // Default title

        // Check user roles and fetch data accordingly
        if (auth()->user()->hasRole('Admin')) {
            $kegiatanVolunteers = KegiatanVolunteer::all();
            $title = 'Semua Kegiatan Volunteer';
        } else if (auth()->user()->hasRole('Pengurus Lembaga')) {
            // Fetch lembagas owned by the user
            $lembagas = auth()->user()->lembagas;

            // Ensure lembagas is not null or empty
            if ($lembagas->isNotEmpty()) {
                $kegiatanVolunteers = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->get();
                $title = 'Semua kegiatan untuk lembaga ' . ($lembagas->first()->nama ?? 'Anda');
            }
        }

        // Return view with default variables
        return view('kegiatan_volunteers.index', compact('kegiatanVolunteers', 'title'));
    }



    /**  
     * Show the form for creating a new resource.  
     */  
    public function create()  
    {  
        $users = User::where('id', '!=', auth()->id())->whereDoesntHave('roles', function($query) {
            $query->whereIn('name', ['Admin', 'Pengurus Lembaga', 'Pengurus Kegiatan']);
        })->get();
        if (auth()->user()->hasRole('Admin')) {  
            $lembagas = Lembaga::all();  
        } else if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            $lembagas = auth()->user()->lembagas;  
        }
        return view('kegiatan_volunteers.create', compact('lembagas', 'users'));  
    }  


    /**  
     * Store a newly created resource in storage.  
     */  
    public function store(Request $request)  
    {  
        $validatedData = $request->validate([  
            'id_lembaga' => 'required|exists:lembagas,id',  
            'nama_kegiatan' => 'required|string',  
            'lokasi' => 'required|string',  
            'deskripsi' => 'required|string',  
            'tanggal' => 'required|date',  
            'kategori' => 'required|in:education,health,environment,social service,community service,animal',  
            'kuota' => 'required|integer|min:1',  
            'jenis' => 'required|in:berbayar,gratis',  
            'harga' => 'required_if:jenis,berbayar|numeric',  
            'banner' => 'required|image|mimes:jpeg,png,jpg|max:2048',  
            'id_pengurus' => 'required|exists:users,id',
        ]);  

        $imageExtension = $request->banner->extension();
        $imageName =  $validatedData['nama_kegiatan'] . '.' . $imageExtension;
        $request->banner->move(public_path('images'), $imageName);  

        KegiatanVolunteer::create([  
            'id_lembaga' => $request->input('id_lembaga'),  
            'nama_kegiatan' => $validatedData['nama_kegiatan'],  
            'lokasi' => $validatedData['lokasi'],  
            'deskripsi' => $validatedData['deskripsi'],  
            'tanggal' => $validatedData['tanggal'],  
            'kategori' => $validatedData['kategori'],  
            'kuota' => $validatedData['kuota'],  
            'jenis' => $validatedData['jenis'],  
            'harga' => $validatedData['harga'] ?? 0,  
            'banner' => 'images/' . $imageName,  
            'id_pengurus' => $validatedData['id_pengurus']
        ]);  

        $user = User::findOrFail($validatedData['id_pengurus']);
        $user->syncRoles(Role::ROLE_PENGURUS_KEGIATAN);

        return redirect()->route('kegiatan_volunteers.index')
            ->with('success', 'Kegiatan Volunteer berhasil ditambahkan');  
    }  


    /**  
     * Display the specified resource.  
     */  
    public function show(string $id)  
    {  
        $kegiatanVolunteer = KegiatanVolunteer::findOrFail($id);  
        return view('kegiatan_volunteers.show', compact('kegiatanVolunteer'));  
    }  


    /**  
     * Show the form for editing the specified resource.  
     */  
    public function edit(string $id)  
    {  
        $kegiatanVolunteer = KegiatanVolunteer::findOrFail($id);  
        $users = User::role('Pengurus Lembaga')->get();

        if (auth()->user()->hasRole('Admin')) {  
            $lembagas = Lembaga::all();  
        } else if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            $lembagas = auth()->user()->lembagas;  
            // Ambil lembaga yang dimiliki oleh pengguna yang sedang login  
            $userLembagaIds = auth()->user()->lembagas->pluck('id')->toArray();  

            // Cek apakah kegiatan yang ingin diedit terkait dengan lembaga yang sama  
            if (!in_array($kegiatanVolunteer->id_lembaga, $userLembagaIds)) {  
                return redirect()->route('kegiatan_volunteers.index')
                    ->with('error', 'Anda tidak memiliki izin untuk mengedit kegiatan ini.');  
            }  
        }  
       
        return view('kegiatan_volunteers.edit', compact('kegiatanVolunteer', 'lembagas', 'users'));  
    }  


    /**  
     * Update the specified resource in storage.  
     */  
    public function update(Request $request, string $id)  
    {  
        $validatedData = $request->validate([  
            'id_lembaga' => 'required|exists:lembagas,id',  
            'nama_kegiatan' => 'required|string',  
            'lokasi' => 'required|string',  
            'deskripsi' => 'required|string',  
            'tanggal' => 'required|date',  
            'kategori' => 'required|in:education,health,environment,social service,community service,animal',  
            'kuota' => 'required|integer|min:1',  
            'jenis' => 'required|in:berbayar,gratis',  
            'harga' => 'nullable|integer|min:0',  
            'banner' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',  
        ]);  


        $kegiatanVolunteer = KegiatanVolunteer::findOrFail($id);  


        // Cek apakah ada banner baru yang diunggah  
        if ($request->hasFile('banner')) {  
            // Hapus banner lama jika ada  
            if ($kegiatanVolunteer->banner) {  
                $oldBannerPath = public_path($kegiatanVolunteer->banner);  
                if (file_exists($oldBannerPath)) {  
                    unlink($oldBannerPath); // Hapus file banner lama  
                }  
            }  


            $imageExtension = $request->banner->extension();  
            $imageName = 'Banner_' . time() . '.' . $imageExtension;  
            $request->banner->move(public_path('images'), $imageName);  


            // Update data Kegiatan dengan banner baru  
            $validatedData['banner'] = 'images/' . $imageName; // Simpan path banner baru  
        } else {  
            // Jika tidak ada banner baru, tetap gunakan banner lama  
            $validatedData['banner'] = $kegiatanVolunteer->banner;  
        }  
       
        $kegiatanVolunteer->update($validatedData);  


        return redirect()->route('kegiatan_volunteers.index')->with('success', 'Kegiatan Volunteer berhasil diperbarui');  
    }  


    /**  
     * Remove the specified resource from storage.  
     */  
    public function destroy(string $id)  
    {  
        // Temukan Kegiatan Volunteer berdasarkan ID  
        $kegiatanVolunteer = KegiatanVolunteer::findOrFail($id);  


        // Hapus banner jika ada  
        if ($kegiatanVolunteer->banner) {  
            $bannerPath = public_path($kegiatanVolunteer->banner);  
            if (file_exists($bannerPath)) {  
                unlink($bannerPath); // Hapus file banner dari sistem file  
            }  
        }  


        // Hapus Kegiatan Volunteer dari database  
        $kegiatanVolunteer->delete();  


        return redirect()->route('kegiatan_volunteers.index')->with('success', 'Kegiatan Volunteer berhasil dihapus');  
    }  


    /**  
     * Export data to Excel.  
     */  
    public function export(Request $request)  
    {  
        if (auth()->user()->hasRole('Admin')) {  
            $kegiatanVolunteers = KegiatanVolunteer::all();  
        } else if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanVolunteers = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->get();  
        }  
   
        return Excel::download(new KegiatanVolunteerExport($kegiatanVolunteers), 'kegiatan_volunteers.xlsx');  
    }  


    public function listActivities()
    {
        $title = 'Volunteer Activities'; 
        
        $kegiatanVolunteers = KegiatanVolunteer::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->take(6)  
            ->get();
        
        return view('kegiatan_volunteers.list', [
            'kegiatanVolunteers' => $kegiatanVolunteers,
            'title' => $title
        ]);
    }

    /**
     * Display a listing of activities for public view.
     */
    public function list(Request $request)
    {
        $query = KegiatanVolunteer::query();

        // Filter by search term (nama_kegiatan)
        if ($request->filled('search')) {
            $query->where('nama_kegiatan', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $kegiatanVolunteers = $query->get();

        return view('kegiatan_volunteers.list', [
            'kegiatanVolunteers' => $kegiatanVolunteers,
            'title' => 'Kegiatan Volunteer'
        ]);
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'id_user' => 'required|exists:users,id',
        'id_kegiatan' => 'required|exists:kegiatan_volunteers,id',
    ]);

    // Simpan data pendaftaran
    Volunteer::Create([
        'id_user' => $validated['id_user'],
        'id_kegiatan' => $validated['id_kegiatan'],
        'status' => 'pending'
    ]);

    return redirect()->back()->with('success', 'Pendaftaran berhasil!');
}

}
