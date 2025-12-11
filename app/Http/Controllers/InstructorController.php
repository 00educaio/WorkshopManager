<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstructorStoreRequest;
use App\Http\Requests\InstructorUpdateRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Log;

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//LEMBRAR DE MUDAR OS LOGS DE ERRO EM PRODUÇÃO
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
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
          event(new Registered($instructor));

          return redirect()
                 ->route('instructors.show', $instructor)
                 ->with('status', [
                    'type' => 'success',
                    'message' => 'Instrutor Criado Com Sucesso.'
                 ]);
      }
      catch (\Exception $e) {
          Log::error('Erro creating instructor: ' . $e->getMessage());

          return back()
              ->withErrors(['error' => 'Erro: ' . $e->getMessage()])
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
                 ->with('status', [
                    'type' => 'success',
                    'message' => 'Instrutor Atualizado Com Sucesso.'
                 ]);
      }
      catch (\Exception $e) {
          Log::error('Erro updating instructor: ' . $e->getMessage());

          return back()
              ->withErrors(['error' => 'Erro: ' . $e->getMessage()])
              ->withInput();
      }

    }

    public function destroy(User $instructor)
    {
      try {
          $instructor->delete();
          
          return redirect()
                 ->route('instructors.index')
                 ->with('status', [
                    'type' => 'deleted',
                    'message' => 'Instrutor Excluído Com Sucesso.'
                 ]);
      }
      catch (\Exception $e) {
          Log::error('Erro deleting instructor: ' . $e->getMessage());

          return back()
              ->withErrors(['error' => 'Erro: ' . $e->getMessage()])
              ->withInput();
      }
    }

    public function trashed()
    {
      $instructors = User::onlyTrashed()->where('role', 'instructor')->get();

      return view('instructors.trashed', compact('instructors'));
    }

    public function restore(User $instructor)
    {
      try {          
          $instructor->restore();
          
          return redirect()
                 ->route('instructors.index')
                 ->with('status', [
                    'type' => 'restored',
                    'message' => 'Instrutor Restaurado Com Sucesso.'
                 ]); //Colocar na view
      }
      catch (\Exception $e) {
          Log::error('Erro restoring instructor: ' . $e->getMessage());

          return back()
              ->withErrors(['error' => 'Erro: ' . $e->getMessage()])
              ->withInput();
    }
}
}