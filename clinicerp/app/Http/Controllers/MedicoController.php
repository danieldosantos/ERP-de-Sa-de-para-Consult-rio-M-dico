<?php
namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\Medico;
use App\Models\UnidadeConsultorio;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicoController extends Controller
{
    public function index(): View { $items=Medico::with(['user','especialidade','unidadeConsultorio'])->latest()->paginate(10); return view('medicos.index', compact('items')); }
    public function create(): View { $users=User::orderBy('name')->get(); $especialidades=Especialidade::orderBy('nome')->get(); $unidadesConsultorios=UnidadeConsultorio::orderBy('nome')->get(); return view('medicos.create', compact('users','especialidades','unidadesConsultorios')); }
    public function store(Request $request): RedirectResponse { $data=$request->validate(['nome'=>'required|string|max:120','crm'=>'required|string|max:30|unique:medicos,crm','email'=>'nullable|email|max:150','telefone'=>'nullable|string|max:20','especialidade_id'=>'required|exists:especialidades,id','unidade_consultorio_id'=>'required|exists:unidades_consultorios,id','user_id'=>'required|exists:users,id|unique:medicos,user_id','ativo'=>'required|boolean']); Medico::create($data); return redirect()->route('medicos.index')->with('status','Médico criado com sucesso.'); }
    public function edit(Medico $medico): View { $users=User::orderBy('name')->get(); $especialidades=Especialidade::orderBy('nome')->get(); $unidadesConsultorios=UnidadeConsultorio::orderBy('nome')->get(); return view('medicos.edit', compact('medico','users','especialidades','unidadesConsultorios')); }
    public function update(Request $request, Medico $medico): RedirectResponse { $data=$request->validate(['nome'=>'required|string|max:120','crm'=>'required|string|max:30|unique:medicos,crm,'.$medico->id,'email'=>'nullable|email|max:150','telefone'=>'nullable|string|max:20','especialidade_id'=>'required|exists:especialidades,id','unidade_consultorio_id'=>'required|exists:unidades_consultorios,id','user_id'=>'required|exists:users,id|unique:medicos,user_id,'.$medico->id,'ativo'=>'required|boolean']); $medico->update($data); return redirect()->route('medicos.index')->with('status','Médico atualizado com sucesso.'); }
    public function destroy(Medico $medico): RedirectResponse { $medico->delete(); return redirect()->route('medicos.index')->with('status','Médico removido com sucesso.'); }
}
