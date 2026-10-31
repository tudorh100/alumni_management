<?php

namespace App\Http\Controllers\alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\alumni_Profile;
use Illuminate\Support\Facades\Storage;
use App\Models\Announcement;
use Illuminate\Validation\Rule;





use Illuminate\Support\Facades\Auth;



class alumniController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
                 $user = Auth::user();

    $profile = alumni_Profile::with('department')
        ->where('user_id', Auth::id())
        ->first();

    // Profile completion percentage
    $completion = 0;
    if ($profile) {
        $fields = ['department_id', 'phone', 'gender', 'dob', 'graduation_year', 'current_address', 'bio', 'photo'];
        $filled = collect($fields)->filter(fn ($f) => !empty($profile->$f))->count();
        $completion = round($filled / count($fields) * 100);
    }

    $totalAlumni        = alumni_Profile::count();
    $sameDepartment     = $profile ? alumni_Profile::where('department_id', $profile->department_id)->count() : 0;
    $totalAnnouncements = Announcement::count();

    $announcements = Announcement::latest()->take(4)->get();

    return view('alumni.dashboard', compact(
        'user', 'profile', 'completion', 'totalAlumni',
        'sameDepartment', 'totalAnnouncements', 'announcements'
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

    public function addprofile()
    {
        //
                if (alumni_Profile::where('user_id', Auth::id())->exists()) {
        return redirect()->route('alumni.show_alumni_profile')
            ->with('error', 'You already have a profile. You can edit it instead.');
    }

    $user = Auth::user();
    $Departments = Department::all();

    return view('alumni.profile', compact('user', 'Departments'));
    }

     public function store_profile(Request $request)
    {
 // One profile per user
    if (alumni_Profile::where('user_id', Auth::id())->exists()) {
        return redirect()
            ->route('alumni.show_alumni_profile')
            ->with('error', 'You already have an alumni profile.');
    }

    $validated = $request->validate([
        'department_id'   => ['required', 'exists:departments,id'],
        'phone'           => ['required', 'digits_between:10,11'],
        'gender'          => ['required', 'in:male,female'],
        'dob'             => ['required', 'date', 'before:today'],
        'graduation_year' => ['required', 'integer', 'min:1962', 'max:' . (now()->year + 6)],
        'current_address' => ['required', 'string'],
        'bio'             => ['required', 'string', 'max:1000'],
        'photo'           => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    ]);

    if ($request->hasFile('photo')) {
        $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
        $request->file('photo')->storeAs('profile_photos', $photoName, 'public');
        $validated['photo'] = $photoName;
    }

    $validated['user_id'] = Auth::id();

    alumni_Profile::create($validated);

    return redirect()
        ->route('alumni.show_alumni_profile')
        ->with('success', 'Profile saved successfully.');
}

    public function showprofile()
    {
        //
        
        $profile = Alumni_Profile::with(['user', 'department']) ->where('user_id', Auth::id())->first();

    if (!$profile) {
        return redirect()
            ->route('alumni.profile')
            ->with('error', 'Please complete your profile first.');
    }

    return view('alumni.show_alumni_profile', compact('profile'));

    }


    public function edit_profile()
    {
     $user        = Auth::user();
    $profile     = alumni_Profile::where('user_id', $user->id)->firstOrFail();
    $Departments = Department::all();

    return view('alumni.edit_profile', compact('user', 'profile', 'Departments'));
    }

public function update_profile(Request $request)
{
    // $profile = alumni_Profile::where('user_id', Auth::id())->firstOrFail();

    // $validated = $request->validate([
    //     'department_id'   => ['required', 'exists:departments,id'],
    //     'phone'           => ['required', 'digits_between:10,11'],
    //     'gender'          => ['required', 'in:male,female'],
    //     'dob'             => ['required', 'date', 'before:today'],
    //     'graduation_year' => ['required', 'integer', 'min:1980', 'max:' . (now()->year + 6)],
    //     'current_address' => ['required', 'string', 'max:500'],
    //     'bio'             => ['required', 'string', 'max:1000'],
    //     'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
    // ]);

    // if ($request->hasFile('photo')) {
    //     if ($profile->photo) {
    //         Storage::disk('public')->delete('profile_photos/' . $profile->photo);
    //     }

    //     $photoName = time() . '_' . $request->file('photo')->getClientOriginalName();
    //     $request->file('photo')->storeAs('profile_photos', $photoName, 'public');
    //     $validated['photo'] = $photoName;
    // } else {
    //     unset($validated['photo']);
    // }

    // $profile->update($validated);

    // return redirect()->route('alumni.show_alumni_profile')->with('success', 'Profile updated successfully.');


$user = Auth::user();
$alumni = alumni_Profile::where('user_id', $user->id)->firstOrFail();

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],

        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($user->id),
        ],

        'department_id' => ['required', 'exists:departments,id'],
        'phone' => ['required', 'string', 'min:10', 'max:11'],
        'gender' => ['required', 'string'],
        'dob' => ['required', 'date'],
        'graduation_year' => ['required', 'integer'],
        'country' => ['nullable', 'string', 'max:255'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Update users table
    |--------------------------------------------------------------------------
    */

    $user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    /*
    |--------------------------------------------------------------------------
    | Update alumni table
    |--------------------------------------------------------------------------
    */

    $alumni = $user->alumni;

    $alumni->update([
        'department_id' => $validated['department_id'],
        'phone' => $validated['phone'],
        'gender' => $validated['gender'],
        'dob' => $validated['dob'],
        'graduation_year' => $validated['graduation_year'],
        'country' => $validated['country'] ?? null,
    ]);

    return redirect()
        ->route('alumni.profile')
        ->with('success', 'Profile updated successfully.');
}








public function viewAnnouncement()
{
    $announcements = Announcement::latest()->paginate(10);
    return view('alumni.viewAnnouncement', compact('announcements'));
      
}

}