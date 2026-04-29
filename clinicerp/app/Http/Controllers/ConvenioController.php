<?php
namespace App\Http\Controllers;
use App\Models\Convenio; use Illuminate\Http\RedirectResponse; use Illuminate\Http\Request; use Illuminate\View\View;
class ConvenioController extends Controller {
public function index(): View { $items=Convenio::latest()->paginate(10); return view('convenios.index', compact('items')); }
public function create(): View { return view('convenios.create'); }
public function store(Request $r): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120|unique:convenios,nome','cnpj'=>'nullable|string|max:30','telefone'=>'nullable|string|max:20','ativo'=>'required|boolean']); Convenio::create($d); return redirect()->route('convenios.index')->with('status','Convênio criado com sucesso.'); }
public function edit(Convenio $convenio): View { return view('convenios.edit', compact('convenio')); }
public function update(Request $r, Convenio $convenio): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120|unique:convenios,nome,'.$convenio->id,'cnpj'=>'nullable|string|max:30','telefone'=>'nullable|string|max:20','ativo'=>'required|boolean']); $convenio->update($d); return redirect()->route('convenios.index')->with('status','Convênio atualizado com sucesso.'); }
public function destroy(Convenio $convenio): RedirectResponse { $convenio->delete(); return redirect()->route('convenios.index')->with('status','Convênio removido com sucesso.'); }}
