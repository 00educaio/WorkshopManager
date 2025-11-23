<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkshopReportController extends Controller
{
    public function index(Request $request)
    {
        return view('reports.index');
    }
}
