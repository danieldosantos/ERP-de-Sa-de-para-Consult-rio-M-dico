<?php

namespace App\Http\Controllers;

use App\Models\Atendente;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AtendenteController extends Controller
{
    public function index(): View { $items = Atendente::with('user')->latest()->paginate(10); return view('atendentes.index', compact('items')); }
    public function create(): View { $users = User::orderBy('name')->get(); return view('atendentes.create', compact('users')); }
    public function store(Request $request): RedirectResponse { $data=$request->validate(['nome'=>'required|string|max:120','telefone'=>'nullable|string|max:20','email'=>'nullable|email|max:150','user_id'=>'required|exists:users,id|unique:atendentes,user_id','ativo'=>'required|boolean']); Atendente::create($data); return redirect()->route('atendentes.index')->with('status','Atendente criado com sucesso.'); }
    public function edit(Atendente $atendente): View { $users = User::orderBy('name')->get(); return view('atendentes.edit', compact('atendente','users')); }
    public function update(Request $request, Atendente $atendente): RedirectResponse { $data=$request->validate(['nome'=>'required|string|max:120','telefone'=>'nullable|string|max:20','email'=>'nullable|email|max:150','user_id'=>'required|exists:users,id|unique:atendentes,user_id,'.$atendente->id,'ativo'=>'required|boolean']); $atendente->update($data); return redirect()->route('atendentes.index')->with('status','Atendente atualizado com sucesso.'); }
    public function destroy(Atendente $atendente): RedirectResponse { $atendente->delete(); return redirect()->route('atendentes.index')->with('status','Atendente removido com sucesso.'); }
}
