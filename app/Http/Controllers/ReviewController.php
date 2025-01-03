<?php  


namespace App\Http\Controllers;  


use Illuminate\Http\Request;  
use App\Models\Review; // Model Review  
use App\Models\User; // Model User  
use App\Models\KegiatanVolunteer; // Model KegiatanVolunteer  
use Maatwebsite\Excel\Facades\Excel;  
use App\Exports\ReviewExport; // Ekspor Review  



class ReviewController extends Controller  
{  
    /**  
     * Display a listing of the resource.  
     */  
    public function index()  
    {  
        if (auth()->user()->hasRole('Admin')) {  
            // Admin bisa melihat semua review  
            $reviews = Review::with('user', 'kegiatan')->get();  
            $title = 'Semua Review';  
        } elseif (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga hanya bisa melihat review terkait lembaga yang mereka kelola  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id');  


            // Ambil review yang terhubung dengan kegiatan lembaga  
            $reviews = Review::whereIn('id_kegiatan', $kegiatanIds)->with('user')->get();  
            $title = 'Semua Review untuk Lembaga ' . ($lembagas->first()->nama);  
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            $kegiatans = auth()->user()->kegiatanVolunteers;
            // Pengurus Kegiatan hanya bisa melihat review untuk kegiatan yang mereka kelola  
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id');  


            // Ambil review yang terhubung dengan kegiatan mereka  
            $reviews = Review::whereIn('id_kegiatan', $kegiatanIds)->with('user')->get();  
            $title = 'Review untuk Kegiatan ' . ($kegiatans->first()->nama_kegiatan);
        }  elseif (auth()->user()->hasRole('Member')) {  
            // Member hanya bisa melihat daftar review  
            $reviews = Review::with('user', 'kegiatan')->get();  
            $title = 'Daftar Review';  
            $activities = KegiatanVolunteer::all(); 
            return view('reviews.list', compact('reviews', 'title', 'activities')); 
        }


        return view('reviews.index', compact('reviews', 'title'));  
    }  


    /**  
     * Show the form for creating a new review.  
     */  
    public function create()  
    {  
        // Ambil semua pengguna dan kegiatan untuk ditampilkan di form  
        $users = User::all();  
        $user = auth()->user();  


        if ($user->hasRole('Admin')) {  
            // Admin bisa memberikan akses ke semua kegiatan  
            $kegiatan = KegiatanVolunteer::all();  
        } elseif ($user->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga hanya melihat kegiatan yang relevan  
            $lembagas = $user->lembagas;  
            $kegiatan = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->get();  
        } elseif ($user->hasRole('Pengurus Kegiatan')) {  
            // Pengurus Kegiatan hanya bisa melihat kegiatan mereka sendiri  
            $kegiatan = KegiatanVolunteer::where('id_pengurus', $user->id)->get();  
        }
        return view('reviews.create', compact('users', 'kegiatan'));  
    }  


    /**  
     * Store a newly created review in storage.  
     */  
    public function store(Request $request)  
    {  
        $validatedData = $request->validate([  
            'id_user' => 'required|exists:users,id',  
            'id_kegiatan' => 'required|exists:kegiatan_volunteers,id',  
            'rating' => 'required|integer|min:1|max:5',  
            'komentar' => 'nullable|string',  
            'tanggal' => 'required|date',  
        ]);  


        // Buat review baru  
        Review::create($validatedData);  


        return redirect()->route('reviews.index')->with('success', 'Review berhasil ditambahkan');  
    }  


    /**  
     * Display the specified resource.  
     */  
    public function show(string $id)  
    {  
        $review = Review::with('user', 'kegiatan')->findOrFail($id);  
        return view('reviews.show', compact('review'));  
    }  


    /**  
     * Show the form for editing the specified review.  
     */  
    public function edit(string $id)  
    {  
        $review = Review::findOrFail($id);  


        // Validasi untuk akses edit berdasarkan peran, serupa dengan Volunteer  
        if (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga hanya bisa mengedit review yang terdaftar di kegiatan lembaga mereka  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id');  


            if (!in_array($review->id_kegiatan, $kegiatanIds->toArray())) {  
                return redirect()->route('reviews.index')->with('error', 'Anda tidak memiliki izin untuk mengedit review ini.');  
            }  
        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            // Pengurus Kegiatan hanya bisa mengedit review untuk kegiatan mereka  
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id');  


            if (!in_array($review->id_kegiatan, $kegiatanIds->toArray())) {  
                return redirect()->route('reviews.index')->with('error', 'Anda tidak memiliki izin untuk mengedit review ini.');  
            }  
        }  


        return view('reviews.edit', compact('review'));  
    }  


    /**  
     * Update the specified review in storage.  
     */  
    public function update(Request $request, string $id)  
    {  
        $validatedData = $request->validate([  
            'rating' => 'required|integer|min:1|max:5',  
            'komentar' => 'nullable|string',  
        ]);  


        $review = Review::findOrFail($id);  
       
        // Update review yang sesuai  
        $review->update($validatedData);  


        return redirect()->route('reviews.index')->with('success', 'Review berhasil diperbarui');  
    }  


    /**  
     * Remove the specified review from storage.  
     */  
    public function destroy(string $id)  
    {  
        $review = Review::findOrFail($id);  
        $review->delete();  


        return redirect()->route('reviews.index')->with('success', 'Review berhasil dihapus');  
    }  


    /**  
     * Export review data to Excel.  
     */  
    public function export()  
    {  
        // Penyiapan query berdasarkan peran pengguna  
        if (auth()->user()->hasRole('Admin')) {  
            // Admin dapat mengekspor semua review  
            $reviews = Review::with('user', 'kegiatan')->get();  


        } elseif (auth()->user()->hasRole('Pengurus Lembaga')) {  
            // Pengurus Lembaga dapat mengekspor review terkait lembaga yang mereka kelola  
            $lembagas = auth()->user()->lembagas;  
            $kegiatanIds = KegiatanVolunteer::whereIn('id_lembaga', $lembagas->pluck('id'))->pluck('id');  


            $reviews = Review::whereIn('id_kegiatan', $kegiatanIds)->get();  


        } elseif (auth()->user()->hasRole('Pengurus Kegiatan')) {  
            // Pengurus Kegiatan dapat mengekspor review terkait kegiatan mereka  
            $kegiatanIds = KegiatanVolunteer::where('id_pengurus', auth()->id())->pluck('id');  


            $reviews = Review::whereIn('id_kegiatan', $kegiatanIds)->get();  
        }  


        return Excel::download(new ReviewExport($reviews), 'reviews.xlsx');  
    }  
}
