<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstructorStoreRequest;
use App\Http\Requests\InstructorUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

    public function edit(User $instructor)
    {
        return view('instructors.edit', compact('instructor'));
    }

    public function store(InstructorStoreRequest $request)
    {
      try {
          $data = $request->validated();
          $data['role'] = 'instructor';
          $data['password'] = bcrypt('12345678');
          $data['avatar'] = 'avatars/default-avatar.png';
          $instructor = User::create($data);
          
          return redirect()
                 ->route('instructors.show', $instructor)
                 ->with('success', 'Instrutor Criado Com Sucesso.'); //Colocar na view
      }
      catch (\Exception $e) {
          Log::error('Erro creating instructor: ' . $e->getMessage());
          
          return back()
                 ->withErrors(['error' => 'Um erro ocorreu ao criar o instrutor.'])
                 ->withInput();
      }
    }

    public function update(InstructorUpdateRequest $request, User $instructor)
    {
      try {
          $data = $request->validated();
          $instructor->update($data);
          
          return redirect()
                 ->route('instructors.show', $instructor)
                 ->with('success', 'Instrutor Atualizado Com Sucesso.'); //Colocar na view
      }
      catch (\Exception $e) {
          Log::error('Erro updating instructor: ' . $e->getMessage());
          
          return back()
                 ->withErrors(['error' => 'Um erro ocorreu ao atualizar o instrutor.'])
                 ->withInput();
      }

    }
}
