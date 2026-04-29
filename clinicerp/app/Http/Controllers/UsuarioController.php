<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
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
        ]);

        Usuario::create($dados);

        return redirect()->route('usuarios.index')->with('status', 'Usuário cadastrado com sucesso.');
    }

    public function edit(Usuario $usuario): View
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150', 'unique:usuarios,email,'.$usuario->id],
            'telefone' => ['nullable', 'string', 'max:20'],
            'ativo' => ['required', 'boolean'],
        ]);

        $usuario->update($dados);

        return redirect()->route('usuarios.index')->with('status', 'Usuário atualizado com sucesso.');
    }

    public function destroy(Usuario $usuario): RedirectResponse
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('status', 'Usuário removido com sucesso.');
    }
}
