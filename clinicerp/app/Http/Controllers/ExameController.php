<?php

namespace App\Http\Controllers;

use App\Models\Exame;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExameController extends Controller
{
    public function index(): View
    {
        $exames = Exame::orderBy('modalidade')->orderBy('descricao')->get();

        return view('exames.index', compact('exames'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'codigo' => ['required', 'string', 'max:40', 'unique:exames,codigo'],
            'descricao' => ['required', 'string', 'max:150'],
            'modalidade' => ['required', 'in:CR,CT,MR,US,MG'],
        ]);

        Exame::create($data);

        return back()->with('status', 'Exame cadastrado com sucesso.');
    }

    public function destroy(Exame $exame): RedirectResponse
    {
        $exame->delete();

        return back()->with('status', 'Exame removido com sucesso.');
    }
}
