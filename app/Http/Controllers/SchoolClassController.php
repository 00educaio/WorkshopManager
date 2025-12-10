<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassStoreRequest;
use App\Http\Requests\ClassUpdateRequest;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $turmas = SchoolClass::all();
        return view('classes.index', compact('turmas'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function show(SchoolClass $class)
    {
        return view('classes.show', compact('class'));
    }

    public function store(ClassStoreRequest $request)
    {   
        try {
            $data = $request->validated();
            $class = SchoolClass::create($data);
            
            return redirect()
                   ->route('classes.show', $class)
                   ->with('success', 'Turma Criada Com Sucesso.');
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
        return view('classes.edit', compact('class'));
    }

    public function update(ClassUpdateRequest $request, SchoolClass $class)
    {
        try {
            $data = $request->validated();
            $class->update($data);
            
            return redirect()
                   ->route('classes.show', $class)
                   ->with('success', 'Turma Atualizada Com Sucesso.');
        }
        catch (\Exception $e) {
            Log::error('Erro updating class: ' . $e->getMessage());
            
            return back()
                   ->withErrors(['error' => 'Um erro ocorreu ao atualizar a turma.'])
                   ->withInput();
        }
    }

}
