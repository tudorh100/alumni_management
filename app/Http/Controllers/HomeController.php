<?php

namespace App\Http\Controllers;

use App\Models\alumni_Profile;
use App\Models\Announcement;
use App\Models\Department;

class HomeController extends Controller
{
    /**
     * Public home page.
     */
    public function index()
    {
        $announcements = Announcement::with('user')
            ->latest()
            ->take(3)
            ->get();

        $totalAlumni        = alumni_Profile::count();
        $totalDepartments   = Department::count();
        $totalAnnouncements = Announcement::count();

        return view('welcome', compact(
            'announcements',
            'totalAlumni',
            'totalDepartments',
            'totalAnnouncements'
        ));
    }
}