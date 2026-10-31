<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\alumni_Profile;
use App\Models\Announcement;

use Barryvdh\DomPDF\Facade\Pdf;


class adminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
 $totalAlumni        = alumni_Profile::count();
    $totalDepartments   = Department::count();
    $totalAnnouncements = Announcement::count();

    // Alumni accounts that have not filled in a profile yet
    $pendingProfiles = max(0, User::where('role', 'user')->count() - $totalAlumni);

    $newThisMonth = alumni_Profile::where('created_at', '>=', now()->startOfMonth())->count();

    // Number of alumni in each department
    $byDepartment = alumni_Profile::selectRaw('department_id, COUNT(*) as total')
        ->groupBy('department_id')
        ->with('department')
        ->orderByDesc('total')
        ->get();

    $recentAlumni  = alumni_Profile::with(['user', 'department'])->latest()->take(5)->get();
    $announcements = Announcement::latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'totalAlumni', 'totalDepartments', 'totalAnnouncements',
        'pendingProfiles', 'newThisMonth', 'byDepartment',
        'recentAlumni', 'announcements'
    ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

public function add_department()
{
     $departments = Department::latest()->get();

    return view('admin.createdepartment', compact('departments'));
    return view('admin.createdepartment');
}

    public function department(Request $request)
{
       $query = Department::query();

    // Search by department name
    if ($request->filled('search')) {
        $query->where('department', 'like', '%' . $request->search . '%');
    }

    $departments = $query
        ->latest()
        ->get();

    return view('admin.createdepartment', compact('departments'));}

public function store_department(Request $request){
    // dd($request);
    
    {
   
     $validated = $request->validate([
        'department'     => ['required', 'string', 'unique:departments,department']
    ]);


    Department::create([
        'department' => $validated['department']
    ]);


    return redirect()->route('admin.createdepartment')->with('success', 'Department created successfully.');
}
}

public function showalumni(Request $request)
{
     $profiles = alumni_Profile::with(['user', 'department'])
        ->when($request->filled('search'), function ($query) use ($request) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('phone', 'like', "%{$search}%")
                  ->orWhere('graduation_year', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('department', function ($d) use ($search) {
                      $d->where('department', 'like', "%{$search}%");
                  });
            });
        })
        ->latest()
        ->paginate(15)
        ->withQueryString();


    return view('admin.showalumni', compact('profiles'));
}

public function destroy_alumni(alumni_Profile $profile)
{
    // Remove the photo file from storage
    if ($profile->photo) {
        Storage::disk('public')->delete('profile_photos/' . $profile->photo);
    }

    $profile->delete();

    return redirect()
        ->back()
        ->with('success', 'Alumni profile deleted successfully.');
}


public function addAnnouncement()
{

$announcements = Announcement::latest()->get();

    return view('admin.addAnnouncement', compact('announcements'));
}

public function storeAnnouncement(Request $request)
{
    $validated = $request->validate([
        'title'     => ['required', 'string', 'max:150'],
        'content'      => ['required', 'string', 'max:3000'],
        ]);

    $validated['user_id']   = Auth::id();

    Announcement::create($validated);

    return redirect()->back()->with('success', 'Announcement posted successfully.');

}


// Show the edit form
public function editAnnouncement(Announcement $announcement)
{
    return view('admin.editAnnouncement', compact('announcement'));
}

public function updateAnnouncement(Request $request, Announcement $announcement)
{
    $validated = $request->validate([
        'title'   => ['required', 'string', 'max:150'],
        'content' => ['required', 'string', 'max:3000'],
    ]);

    $announcement->update($validated);

    return redirect()
        ->route('admin.addAnnouncement')
        ->with('success', 'Announcement updated successfully.');
}

public function destroyAnnouncement(Announcement $announcement)
{
    $announcement->delete();

    return redirect()->back()->with('success', 'Announcement deleted successfully.');
}


 public function exportAlumniPdf()

  {
    $profiles = alumni_Profile::with([
        'user',
        'department'
    ])->get();

    $pdf = Pdf::loadView('admin.alumni_pdf', [
        'profiles' => $profiles
    ])->setPaper('a4', 'landscape');

    return $pdf->download('all_alumni_profiles.pdf');




}




}