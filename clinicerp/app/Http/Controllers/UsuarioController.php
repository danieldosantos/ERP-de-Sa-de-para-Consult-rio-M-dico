<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UsuarioController extends Controller
{
    public function index(): View|RedirectResponse
    {
        if (! Schema::hasTable('usuarios')) {
            return redirect()->route('dashboard')->with('status', 'Tabela usuarios não encontrada. Execute: php artisan migrate');
        }

        $usuarios = Usuario::query()->latest()->paginate(10);

        return view('usuarios.index', compact('usuarios'));
    }

    public function create(): View|RedirectResponse
    {
        if (! Schema::hasTable('usuarios')) {
            return redirect()->route('dashboard')->with('status', 'Tabela usuarios não encontrada. Execute: php artisan migrate');
        }

        return view('usuarios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if (! Schema::hasTable('usuarios')) {
            return redirect()->route('dashboard')->with('status', 'Tabela usuarios não encontrada. Execute: php artisan migrate');
        }

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'ativo' => ['required', 'boolean'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        DB::transaction(function () use ($dados) {
            $user = User::firstOrNew(['email' => $dados['email']]);
            $user->name = $dados['nome'];
            $user->password = Hash::make($dados['password']);
            $user->save();

            Usuario::create([
                'user_id' => $user->id,
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'telefone' => $dados['telefone'] ?? null,
                'ativo' => $dados['ativo'],
            ]);
        });

        return redirect()->route('usuarios.index')->with('status', 'Usuário cadastrado e habilitado para login com sucesso.');
    }

    public function edit(Usuario $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', Rule::unique('usuarios', 'email')->ignore($usuario->id), Rule::unique('users', 'email')->ignore($usuario->user_id)],
            'telefone' => ['nullable', 'string', 'max:20'],
            'ativo' => ['required', 'boolean'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        DB::transaction(function () use ($dados, $usuario) {
            $usuario->update([
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'telefone' => $dados['telefone'] ?? null,
                'ativo' => $dados['ativo'],
            ]);

            $user = $usuario->user;

            if (! $user) {
                $user = User::firstOrNew(['email' => $dados['email']]);
                $usuario->user()->associate($user);
            }

            $user->name = $dados['nome'];
            $user->email = $dados['email'];

            if (! empty($dados['password'])) {
                $user->password = Hash::make($dados['password']);
            }

            $user->save();
            $usuario->save();
        });

        return redirect()->route('usuarios.index')->with('status', 'Usuário atualizado com sucesso.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        DB::transaction(function () use ($usuario) {
            $user = $usuario->user;
            $usuario->delete();

            if ($user) {
                $user->delete();
            }
        });

        return redirect()->route('usuarios.index')->with('status', 'Usuário removido com sucesso.');
    }
}
