<?php
namespace App\Http\Controllers;
use App\Models\Paciente; use Illuminate\Http\RedirectResponse; use Illuminate\Http\Request; use Illuminate\View\View;
class PacienteController extends Controller {
public function index(): View { $items=Paciente::latest()->paginate(10); return view('pacientes.index', compact('items')); }
public function create(): View { return view('pacientes.create'); }
public function store(Request $r): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120','cpf'=>'nullable|string|max:20|unique:pacientes,cpf','telefone'=>'nullable|string|max:20','email'=>'nullable|email|max:150','data_nascimento'=>'nullable|date','ativo'=>'required|boolean']); Paciente::create($d); return redirect()->route('pacientes.index')->with('status','Paciente criado com sucesso.'); }
public function edit(Paciente $paciente): View { return view('pacientes.edit', compact('paciente')); }
public function update(Request $r, Paciente $paciente): RedirectResponse { $d=$r->validate(['nome'=>'required|string|max:120','cpf'=>'nullable|string|max:20|unique:pacientes,cpf,'.$paciente->id,'telefone'=>'nullable|string|max:20','email'=>'nullable|email|max:150','data_nascimento'=>'nullable|date','ativo'=>'required|boolean']); $paciente->update($d); return redirect()->route('pacientes.index')->with('status','Paciente atualizado com sucesso.'); }
public function destroy(Paciente $paciente): RedirectResponse { $paciente->delete(); return redirect()->route('pacientes.index')->with('status','Paciente removido com sucesso.'); }}
