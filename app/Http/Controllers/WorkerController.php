<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class WorkerController extends Controller
{
    public function index()
    {
        $workers = User::where('role', 'trabajador')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('workers.index', compact('workers'));
    }

    public function create()
    {
        return view('workers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'trabajador',
        ]);

        return redirect()->route('workers.index')->with('success', 'Trabajador creado correctamente.');
    }

    public function edit(User $worker)
    {
        abort_unless($worker->role === 'trabajador', 404);

        return view('workers.edit', compact('worker'));
    }

    public function update(Request $request, User $worker)
    {
        abort_unless($worker->role === 'trabajador', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['nullable', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($worker->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $worker->name = $validated['name'];
        $worker->surname = $validated['surname'] ?? null;
        $worker->email = $validated['email'];
        $worker->phone = $validated['phone'] ?? null;

        if (!empty($validated['password'])) {
            $worker->password = Hash::make($validated['password']);
        }

        $worker->save();

        return redirect()->route('workers.index')->with('success', 'Trabajador actualizado correctamente.');
    }

    public function destroy(User $worker)
    {
        abort_unless($worker->role === 'trabajador', 404);

        $worker->delete();

        return redirect()->route('workers.index')->with('success', 'Trabajador eliminado correctamente.');
    }
}