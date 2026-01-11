<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassStoreRequest;
use App\Http\Requests\ClassUpdateRequest;
use App\Models\SchoolClass;
use App\Models\SchoolClassOrigin;
use App\Models\WorkshopReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $classes = SchoolClass::with('origin')->get();

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        $origins = SchoolClassOrigin::all();
        return view('classes.create', compact('origins'));
    }

    public function show(SchoolClass $class)
    {
        $classInfo = null;
        $recentWorkshops = null;
        $userRole = Auth::user()->role;

        if ($userRole == 'manager' || $userRole == 'admin') {
            $classInfo = $class->instructorsWithWorkshopCount();
        } 
        elseif ($userRole == 'instructor') {

            $recentWorkshops = WorkshopReport::whereHas('schoolClasses', function ($q) use ($class) {
                $q->where('school_class_id', $class->id); 
            })
            ->where('instructor_id', Auth::id())
            ->orderBy('report_date', 'desc')
            ->paginate(5);
        }
        else{
            abort(403, 'Acesso Negado');
        }

        return view('classes.show', compact('class', 'classInfo', 'recentWorkshops'));
    }

    public function store(ClassStoreRequest $request)
    {   
        try {
            $data = $request->validated();
            SchoolClass::create($data);
            
            return redirect()
                    ->route('classes.index')
                    ->with('status', [
                        'type' => 'success',
                        'message' => 'Turma Criada Com Sucesso.'
                    ]);
        }
        catch (\Exception $e) {
            Log::error('Erro creating class: ' . $e->getMessage());
            
            return back()
                   ->withErrors(['error' => 'Um erro ocorreu ao criar a turma.'])
                   ->withInput();
        }
    }
    public function edit(SchoolClass $class)
    {
        $origins = SchoolClassOrigin::all();
        return view('classes.edit', compact('class', 'origins'));
    }

    public function update(ClassUpdateRequest $request, SchoolClass $class)
    {
        try {
            $data = $request->validated();
            $class->update($data);
            
            return redirect()
                   ->route('classes.show', $class)
                   ->with('status', [
                      'type' => 'success',
                      'message' => 'Turma Atualizada Com Sucesso.'
                   ]);
        }
        catch (\Exception $e) {
            Log::error('Erro updating class: ' . $e->getMessage());
            
            return back()
                   ->withErrors(['error' => 'Um erro ocorreu ao atualizar a turma.'])
                   ->withInput();
        }
    }

    public function destroy(SchoolClass $class)
    {
        try {
            $class->delete();
            
            return redirect()
                   ->route('classes.index')
                   ->with('status', [
                      'type' => 'deleted',
                      'message' => 'Turma Deletada Com Sucesso.'
                   ]);
        }
        catch (\Exception $e) {
            Log::error('Erro deleting class: ' . $e->getMessage());
            
            return back()
                   ->withErrors(['error' => 'Um erro ocorreu ao deletar a turma.']);
        }
    }

    public function trashed()
    {
        $classes = SchoolClass::onlyTrashed()->get();
        return view('classes.trashed', compact('classes'));
    }

    public function restore(SchoolClass $class)
    {
        try {
            $class->restore();
            
            return redirect()
                   ->route('classes.index')
                   ->with('status', [
                      'type' => 'restored',
                      'message' => 'Turma Restaurada Com Sucesso.'
                   ]);
        }
        catch (\Exception $e) {
            Log::error('Erro restoring class: ' . $e->getMessage());
            
            return back()
                   ->withErrors(['error' => 'Um erro ocorreu ao restaurar a turma.']);
        }
    }

}
