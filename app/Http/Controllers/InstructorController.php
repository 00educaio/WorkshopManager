<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WorkshopReportSchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstructorController extends Controller
{
    public function index()
    {
      $instructors = User::where('role', 'instructor')->get();

      return view('instructors.index', compact('instructors'));
    }

    public function show(User $instructor)
    {
      $classes = $instructor->schoolClassesWithCount()->get();

      return view('instructors.show', compact('instructor', 'classes'));
    }

    public function create()
    {
        return view('instructors.create');
    }
}
