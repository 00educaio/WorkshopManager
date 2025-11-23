<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $turmas = SchoolClass::all();
        return view('classes.index', compact('turmas'));
    }
}
