<?php
namespace App\Http\Controllers;
use App\Models\UnidadeConsultorio; use Illuminate\Http\RedirectResponse; use Illuminate\Http\Request; use Illuminate\View\View;
class UnidadeConsultorioController extends Controller {
public function index(): View { $items=UnidadeConsultorio::latest()->paginate(10); return view('unidades_consultorios.index', compact('items')); }
public function create(): View { return view('unidades_consultorios.create'); }
public function store(Request $r): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120|unique:unidades_consultorios,nome','endereco'=>'nullable|string|max:255','telefone'=>'nullable|string|max:20','ativo'=>'required|boolean']); UnidadeConsultorio::create($d); return redirect()->route('unidades-consultorios.index')->with('status','Unidade/consultório criado com sucesso.'); }
public function edit(UnidadeConsultorio $unidades_consultorio): View { return view('unidades_consultorios.edit', ['unidadeConsultorio'=>$unidades_consultorio]); }
public function update(Request $r, UnidadeConsultorio $unidades_consultorio): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120|unique:unidades_consultorios,nome,'.$unidades_consultorio->id,'endereco'=>'nullable|string|max:255','telefone'=>'nullable|string|max:20','ativo'=>'required|boolean']); $unidades_consultorio->update($d); return redirect()->route('unidades-consultorios.index')->with('status','Unidade/consultório atualizado com sucesso.'); }
public function destroy(UnidadeConsultorio $unidades_consultorio): RedirectResponse { $unidades_consultorio->delete(); return redirect()->route('unidades-consultorios.index')->with('status','Unidade/consultório removido com sucesso.'); }}
