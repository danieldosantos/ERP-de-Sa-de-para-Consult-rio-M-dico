<?php
namespace App\Http\Controllers;
use App\Models\Especialidade; use Illuminate\Http\RedirectResponse; use Illuminate\Http\Request; use Illuminate\View\View;
class EspecialidadeController extends Controller {
public function index(): View { $items=Especialidade::latest()->paginate(10); return view('especialidades.index', compact('items')); }
public function create(): View { return view('especialidades.create'); }
public function store(Request $r): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120|unique:especialidades,nome','descricao'=>'nullable|string|max:255','ativo'=>'required|boolean']); Especialidade::create($d); return redirect()->route('especialidades.index')->with('status','Especialidade criada com sucesso.'); }
public function edit(Especialidade $especialidade): View { return view('especialidades.edit', compact('especialidade')); }
public function update(Request $r, Especialidade $especialidade): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120|unique:especialidades,nome,'.$especialidade->id,'descricao'=>'nullable|string|max:255','ativo'=>'required|boolean']); $especialidade->update($d); return redirect()->route('especialidades.index')->with('status','Especialidade atualizada com sucesso.'); }
public function destroy(Especialidade $especialidade): RedirectResponse { $especialidade->delete(); return redirect()->route('especialidades.index')->with('status','Especialidade removida com sucesso.'); }}
